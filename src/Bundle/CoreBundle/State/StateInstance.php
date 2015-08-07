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
use Accard\Bundle\CoreBundle\Exception\DuplicateOptionException;
use Accard\Bundle\CoreBundle\Exception\OptionNotFoundException;

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
    private $objects = array();

    /**
     * Option state objects array.
     *
     * @var OptionStateInterface[]
     */
    private $options = array();

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
     * @param OptionStateInterface[] $resources
     */
    public function __construct(array $objects = array(), array $options = array())
    {
        foreach ($objects as $object) {
            $this->addObject($object);
        }

        foreach ($options as $option) {
            $this->addOption($option);
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
     * Get options.
     *
     * @return OptionStateInterface[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get option by name.
     *
     * @param string $name
     * @return OptionStateInterface[]
     */
    public function getOption($name)
    {
        $this->assertOptionExists($name);

        return $this->options[$name];
    }

    /**
     * Get option by id.
     *
     * @throws OptionNotFoundException If option can not be found locally.
     * @param integer $id
     * @return OptionStateInterface
     */
    public function getOptionById($id)
    {
        foreach ($this->options as $option) {
            if ($id === $option->id) {
                return $option;
            }
        }

        throw new OptionNotFoundException($id);
    }

    /**
     * Test for presence of an option by name.
     *
     * @param string $name
     * @return boolean
     */
    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    /**
     * Test for presence of an option by id.
     *
     * @param integer $id
     * @return boolean
     */
    public function hasOptionById($id)
    {
        foreach ($this->options as $option) {
            if ($id === $option->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add option with optional name.
     *
     * @param string|OptionStateInterface $name
     * @param OptionStateInterface|null
     */
    public function addOption($name, OptionStateInterface $option = null)
    {
        if ($name instanceof OptionStateInterface) {
            $option = $name;
            $name = $option->name;
        }

        if (!$name) {
            throw new \InvalidArgumentException('State option must have a name set.');
        }

        if ($this->hasOption($name)) {
            throw new DuplicateOptionException($name);
        }

        $this->options[$name] = $option;

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
        return array('objects', 'options');
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
            'options' => $this->options,
        );
    }

    /**
     * Assert object exists.
     *
     * @throws ObjectNotFoundException If object can not be found locally.
     * @param string $name
     */
    private function assertObjectExists($name)
    {
        if (!$this->hasObject($name)) {
            throw new ObjectNotFoundException($name);
        }
    }

    /**
     * Assert option exists.
     *
     * @throws OptionNotFoundException If option can not be found locally.
     * @param string $name
     */
    private function assertOptionExists($name)
    {
        if (!$this->hasOption($name)) {
            throw new OptionNotFoundException($name);
        }
    }

}
