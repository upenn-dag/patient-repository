<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\State;

use JsonSerializable;
use Accard\Bundle\CoreBundle\AccardState;
use Accard\Bundle\CoreBundle\Exception\DuplicateObjectException;
use Accard\Bundle\CoreBundle\Exception\ObjectNotFoundException;

/**
 * State instance.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class StateInstance implements JsonSerializable
{
    /**
     * State objects array.
     *
     * @var ObjectStateInterface[]
     */
    private $objects;

    /**
     * Resource objects array.
     *
     * @var ObjectResourceInterface[]
     */
    private $resources;

    /**
     * State object hash.
     *
     * @var string
     */
    private $hash;


    /**
     * Constructor.
     *
     * @param ObjectStateInterface[] $objects
     * @param ObjectResourceInterface[] $resources
     */
    public function __construct(array $objects = array(), array $resources = array())
    {
        foreach ($objects as $object) {
            $this->addObject($object);
        }

        foreach ($resources as $resource) {
            $this->addResource($resource);
        }
    }

    /**
     * Get state objects.
     *
     * @return ObjectStateInterface[]
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * Get state object by name.
     *
     * @throws InvalidArgumentException If object does not exist.
     * @param string $name
     * @return ObjectStateInterface
     */
    public function getObject($name)
    {
        $this->assertObjectExists($name);

        return $this->objects[$name];
    }

    /**
     * Test for presence of state object by name or instance.
     *
     * @param ObjectStateInterface|string $name
     * @return boolean
     */
    public function hasObject($name)
    {
        if ($name instanceof ObjectStateInterface) {
            return in_array($name, $this->objects);
        }

        return isset($this->objects[$name]);
    }

    /**
     * Add a state object by name or instance.
     *
     * @param string|ObjectStateInterface $name
     * @param ObjectStateInterface $object
     * @return self
     */
    public function addObject($name, ObjectStateInterface $object = null)
    {
        if ($name instanceof ObjectStateInterface) {
            $object = $name;
            $name = $object->getName();
        }

        if (!$name) {
            throw new \InvalidArgumentException('State object must have a name set.');
        }

        if ($this->hasObject($name)) {
            throw new DuplicateObjectException($name);
        }

        $this->objects[$name] = $object;

        return $this;
    }

    /**
     * Remove a state object by name or instance.
     *
     * @param string|ObjectStateInterface $name
     * @return self
     */
    public function removeObject($name)
    {
        if ($name instanceof ObjectStateInterface) {
            if ($name = array_search($name, $this->objects)) {
                unset($this->objects[$name]);

                return $this;
            }

            throw new \InvalidArgumentException('State object could not be located.');
        }

        $this->assertObjectExists($name);
        unset($this->objects[$name]);

        return $this;
    }

    /**
     * Generate state hash.
     *
     * @return string
     */
    public function generateHash()
    {
        $this->hash = md5(serialize($this));

        return $this->hash;
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        return array('objects');
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $this->generateHash();

        return array(
            'hash' => $this->hash,
            'objects' => $this->objects,
        );
    }

    /**
     * Assert object exists.
     *
     * @throws InvalidArgumentException If object can not be found locally.
     * @param string $name
     */
    private function assertObjectExists($name)
    {
        if (!$this->hasObject($name)) {
            throw new ObjectNotFoundException($name);
        }
    }
}
