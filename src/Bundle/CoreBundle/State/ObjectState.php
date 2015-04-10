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

use Accard\Bundle\CoreBundle\AccardState;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Accard\Bundle\CoreBundle\Exception\ObjectPrototypeNotFoundException;

/**
 * Accard state object representation.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ObjectState implements ObjectStateInterface
{
    protected $accardState;

    public $name;
    public $class;
    public $isPrototyped = false;
    public $prototypes = array();
    public $isFielded = false;
    public $fields = array();
    private $hash;


    /**
     * Constructor.
     *
     * @param string $name
     * @param AccardState $accardState
     */
    public function __construct($name, AccardState $accardState)
    {
        $this->name = $name;
        $this->accardState = $accardState;
    }

    /**
     * Get object name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Test if object is prototyped.
     *
     * @return boolean
     */
    public function isPrototyped()
    {
        return $this->isPrototyped;
    }

    /**
     * Set if object is prototyped.
     *
     * @param boolean $prototyped
     * @return self
     */
    public function setPrototyped($prototyped)
    {
        $this->isPrototyped = $prototyped;

        return $this;
    }

    /**
     * Test if object is fielded.
     *
     * @return boolean
     */
    public function isFielded()
    {
        return $this->isFielded;
    }

    /**
     * Set if object is fielded.
     *
     * @param boolean $fielded
     * @return self
     */
    public function setFielded($fielded)
    {
        $this->isFielded = $fielded;

        return $this;
    }

    /**
     * Get object class.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set object class.
     *
     * @param string $class
     * @return self
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Prepare object.
     *
     * @param ClassMetadata $metadata
     * @return self
     */
    public function prepareObject(ClassMetadata $metadata)
    {
        return $this;
    }

    /**
     * Get prototype states.
     *
     * @return ObjectPrototypeState[]
     */
    public function getPrototypes()
    {
        return $this->prototypes;
    }

    /**
     * Test for presence of prototype state.
     *
     * @param string $prototypeName
     * @return boolean
     */
    public function hasPrototype($prototypeName)
    {
        return isset($this->prototypes[$prototypeName]);
    }

    /**
     * Get prototype by name.
     *
     * @throws ObjectPrototypeNotFoundException If prototype does not exist.
     * @param string $prototypeName
     * @return ObjectPrototypeState
     */
    public function getPrototype($prototypeName)
    {
        if (!$this->hasPrototype($prototypeName)) {
            throw new ObjectPrototypeNotFoundException($this->name, $prototypeName);
        }

        return $this->prototypes[$prototypeName];
    }

    /**
     * Get prototype names.
     *
     * @return string[]
     */
    public function getPrototypeNames()
    {
        return array_keys($this->prototypes);
    }

    /**
     * Add prototype to prototype list.
     *
     * @param ObjectPrototypeState $prototypeState
     * @return self
     */
    public function addPrototype(ObjectPrototypeState $prototypeState)
    {
        $this->prototypes[$prototypeState->name] = $prototypeState;

        return $this;
    }

    /**
     * Prepare prototype state for prototype list.
     *
     * @param ObjectPrototypeState $prototypeState
     * @param PrototypeInterface $prototype
     * @return self
     */
    public function preparePrototype(ObjectPrototypeState $prototypeState, $prototype)
    {
        return $this;
    }

    /**
     * Get fields.
     *
     * @return ObjectStaticFieldState[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Test for presence of field by name.
     *
     * @param string $fieldName
     * @return boolean
     */
    public function hasField($fieldName)
    {
        return isset($this->fields[$fieldName]);
    }

    /**
     * Get field by name.
     *
     * @throws InvalidArgumentException If field does not exist.
     * @param string $fieldName
     * @return ObjectStaticFieldState[]
     */
    public function getField($fieldName)
    {
        if (!$this->hasField($fieldName)) {
            throw new \InvalidArgumentException(
                sprintf('The field "%s" is not part of the %s object.', $fieldName, $this->name)
            );
        }

        return $this->fields[$fieldName];
    }

    /**
     * Get field names.
     *
     * @return string[]
     */
    public function getFieldNames()
    {
        return array_keys($this->fields);
    }

    /**
     * Add field to field list.
     *
     * @param ObjectStaticFieldState $fieldState
     * @return self
     */
    public function addField(ObjectStaticFieldState $fieldState)
    {
        $this->fields[$fieldState->name] = $fieldState;
    }

    /**
     * Prepare field state for field list.
     *
     * @param ObjectStaticFieldState $fieldState
     * @param FieldInterface $field
     * @return self
     */
    public function prepareField(ObjectStaticFieldState $fieldState, $field)
    {
        return $this;
    }

    /**
     * Get accard state object.
     *
     * @return AccardState
     */
    public function getAccardState()
    {
        return $this->accardState;
    }

    /**
     * Generate object state hash.
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
    public function jsonSerialize()
    {
        $out = array(
            'hash' => $this->generateHash(),
        );

        foreach ($this->__sleep() as $param) {
            $out[$param] = $this->$param;
        }

        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        $baseFields = array('name', 'class', 'isPrototyped', 'isFielded');

        if ($this->isFielded) {
            $baseFields[] = 'fields';
        }

        if ($this->isPrototyped) {
            $baseFields[] = 'prototypes';
        }

        return $baseFields;
    }

    /**
     * {@inheritdoc}
     */
    public function __wakeup()
    {
        foreach ($this->prototypes as $prototype) {
            $prototype->setParent($this);
        }

        foreach ($this->fields as $field) {
            $field->setParent($this);
        }
    }
}
