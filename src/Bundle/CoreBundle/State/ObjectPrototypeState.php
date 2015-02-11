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

/**
 * Accard prototype state representation.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ObjectPrototypeState implements JsonSerializable
{
    private $parent;

    public $id;
    public $name;
    public $presentation;
    public $description;
    public $fields = array();
    public $extras = array();

    /**
     * Constructor.
     *
     * @param string $id
     * @param ObjectState $objectState
     */
    public function __construct($id, ObjectStateInterface $objectState)
    {
        $this->parent = $objectState;
        $this->id = $id;
    }

    /**
     * Set prototype name.
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set prototype presentation.
     *
     * @param string $presentation
     * @return self
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Set prototype description.
     *
     * @param string|null $description
     * @return self
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get fields.
     *
     * @return ObjectFieldState[]
     */
    public function getFields()
    {
        $fields = array();
        foreach ($this->fields as $field) {
            $fields[$field] = $this->parent->getField($field);
        }

        return $fields;
    }

    /**
     * Get list of field names.
     *
     * @return string[]
     */
    public function getFieldNames()
    {
        return $this->fields;
    }

    /**
     * Add field to fields list.
     *
     * @param string|ObjectFieldState $field
     * @return self
     */
    public function addField($field)
    {
        if ($field instanceof ObjectFieldState) {
            $field = $field->name;
        }

        if (!in_array($field, $this->fields)) {
            $this->fields[] = $field;
        }

        return $this;
    }

    /**
     * Add extra to listing.
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function addExtra($key, $value)
    {
        if (!$this->hasExtra($key)) {
            $this->extras[$key] = $value;
        }

        return $this;
    }

    /**
     * Test for presence of an extra.
     *
     * @param string $key
     * @return boolean
     */
    public function hasExtra($key)
    {
        return isset($this->extras[$key]);
    }

    /**
     * Get extra.
     *
     * @param string $key
     * @return mixed
     */
    public function getExtra($key)
    {
        if (!$this->hasExtra($key)) {
            throw new \InvalidArgumentException(sprintf('Prototype does not have an extra parameter with key "%s".', $key));
        }

        return $this->extras[$key];
    }

    /**
     * Remove an extra.
     *
     * @param string $key
     * @return self
     */
    public function removeExtra($key)
    {
        if (!$this->hasExtra($key)) {
            throw new \InvalidArgumentException(sprintf('Prototype does not have an extra parameter with key "%s".', $key));
        }

        unset($this->extras[$key]);

        return $this;
    }

    /**
     * Set parent.
     *
     * !! This should ONLY be used by the deserializer calls to ensure proper
     * object linking, and is public for that reason.
     *
     * @param ObjectState $parent
     */
    public function setParent(ObjectStateInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $params = $this->__sleep();
        $out = array();

        foreach ($params as $param) {
            $out[$param] = $this->$param;
        }

        unset($out['extras']);

        foreach ($this->extras as $extra => $extraValue) {
            $out[$extra] = $extraValue;
        }

        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        return array('id', 'name', 'presentation', 'description', 'fields', 'extras');
    }
}
