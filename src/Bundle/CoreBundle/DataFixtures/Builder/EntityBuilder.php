<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\DataFixtures\Builder;

use ReflectionObject;
use BadMethodCallException;
use Accard\Bundle\CoreBundle\Exception\FixtureException;
use Accard\Bundle\CoreBundle\DataFixtures\FixtureManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Basic entity builder.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class EntityBuilder
{
    /**
     * Property accessor.
     *
     * @var PropertyAccessorInterface
     */
    private static $propertyAccessor;

    /**
     * Entity alias.
     *
     * @var string
     */
    private $entityAlias;

    /**
     * Entity.
     *
     * @var object
     */
    private $entity;

    /**
     * Fixture manager.
     *
     * @var FixtureManagerInterface
     */
    private $fixtureManager;

    /**
     * Entity reflection.
     *
     * @var ReflectionObject
     */
    private $refl;

    /**
     * Persistence.
     *
     * @var boolean
     */
    private $persisted = false;


    /**
     * Constructor.
     *
     * @param string $entityAlias
     * @param object $entity
     * @param FixtureManagerInterface $fixtureManager
     */
    public function __construct($entityAlias, $entity, FixtureManagerInterface $fixtureManager)
    {
        $this->entityAlias = $entityAlias;
        $this->entity = $entity;
        $this->fixtureManager = $fixtureManager;

        $this->refl = new ReflectionObject($entity);

        if (null === static::$propertyAccessor) {
            static::$propertyAccessor = PropertyAccess::createPropertyAccessor();
        }
    }

    /**
     * Mass set data.
     *
     * Uses Symfony PropertyAccess component to do dynamic, simple setting of data
     * on the underlying entity.
     *
     * @param array $data
     * @return EntityBuilder
     */
    public function setData(array $data)
    {
        $this->assertNotPersisted();

        foreach ($data as $key => $value) {
            static::$propertyAccessor->setValue($this->entity, $key, $value);
        }

        return $this;
    }

    /**
     * Get the entity.
     *
     * @return object
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * End builder construction.
     *
     * @return FixtureManagerInterface
     */
    public function end()
    {
        $this->assertNotPersisted();

        return $this->fixtureManager;
    }

    /**
     * Persist.
     *
     * @return OptionBuilder
     */
    public function persist()
    {
        $this->end();

        $this->fixtureManager->objectManager->persist($this->entity);
        $this->persisted = true;

        return $this;
    }

    /**
     * Magic caller.
     *
     * Sends methods called on the entity builder directly to the entity itself,
     * allowing a dynamic, simpler way to create entities via fixtures.
     *
     * @param string $method
     * @param array $args
     * @return EntityBuilder
     */
    public function __call($method, array $args)
    {
        if (!$this->refl->hasMethod($method)) {
            throw new FixtureException(sprintf(
                'Method %s::%s has been called in an entity builder, but does not exist on the underlying entity.',
                $this->refl->getName(),
                $method
            ));
        }

        $method = $this->refl->getMethod($method);
        $returnVal = $method->invokeArgs($this->entity, $args);

        return $this;
    }

    /**
     * Assert option isn't already persisted
     */
    private function assertNotPersisted()
    {
        if ($this->persisted) {
            throw new RedundantPersistanceException($this->entityAlias, get_class($this->entity));
        }
    }
}
