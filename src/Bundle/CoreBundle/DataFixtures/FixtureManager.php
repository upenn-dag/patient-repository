<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\DataFixtures;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Accard fixture manager.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class FixtureManager implements FixtureManagerInterface, ContainerAwareInterface
{
    /**
     * Symfony container.
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Object manager.
     *
     * @var ObjectManager
     */
    public $objectManager;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function setObjectManager(ObjectManager $manager = null)
    {
        $this->objectManager = $manager;
    }

    /**
     * Create prototype builder.
     * 
     * @param string $subject
     * @param string $name
     * @param string $presentation
     * 
     * @return PrototypeBuilder $prototypeBuilder
     */
    public function createPrototype($subject, $name = null, $presentation = null)
    {
        $prototypeBuilder = new Builder\PrototypeBuilder($subject, $this);

        $name && $prototypeBuilder->setName($name);
        $presentation && $prototypeBuilder->setPresentation($presentation);

        return $prototypeBuilder;
    }

    /**
     * Create field builder.
     * 
     * @param string $subject
     * @param string $name
     * @param string $presentation
     * 
     * @return FieldBuilder $fieldBuilder
     */
    public function createField($subject, $name, $presentation, $type)
    {
        $fieldBuilder = new Builder\FieldBuilder($subject, $this);
        $fieldBuilder->setName($name);
        $fieldBuilder->setPresentation($presentation);
        $fieldBuilder->setType($type);

        return $fieldBuilder;
    }

    /**
     * Create option builder.
     * 
     * @param string $name
     * @param string $presentation
     * 
     * @return OptionBuilder $optionBuilder
     */
    public function createOption($name, $presentation)
    {
        $optionBuilder = new Builder\OptionBuilder($this);
        $optionBuilder->setName($name);
        $optionBuilder->setPresentation($presentation);

        return $optionBuilder;
    }

    /**
     * Persist object
     * 
     * @param $object
     */
    public function save($object)
    {
        // Make better exception...
        if (!$this->objectManager) {
            throw new \Exception('No object manager is set!');
        }

        $this->objectManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function resolveClassFromParameter($parameter)
    {
        return $this->container->getParameter($parameter);
    }
}
