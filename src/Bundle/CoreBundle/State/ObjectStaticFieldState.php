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
 * Accard field state representation.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ObjectStaticFieldState implements JsonSerializable
{
    protected $parent;
    protected $hash;

    public $name;
    public $presentation;
    public $type;
    public $extras = array();


    /**
     * Constructor.
     *
     * @param ObjectStateInterface $objectState
     */
    public function __construct(ObjectStateInterface $objectState)
    {
        $this->parent = $objectState;
    }

    /**
     * Test if field is dynamic.
     *
     * @return true
     */
    public function isDynamic()
    {
        return false;
    }

    /**
     * Set field name.
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
     * Set field presentation.
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
     * Set field type.
     *
     * @param string $presentation
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

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
            throw new \InvalidArgumentException(sprintf('Field does not have an extra parameter with key "%s".', $key));
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
            throw new \InvalidArgumentException(sprintf('Field does not have an extra parameter with key "%s".', $key));
        }

        unset($this->extras[$key]);

        return $this;
    }

    /**
     * Generate field hash.
     *
     * @return string
     */
    public function generateHash()
    {
        $this->hash = md5(serialize($this));

        return $this->hash;
    }

    /**
     * Set parent.
     *
     * !! This should ONLY be used by the deserializer calls to ensure proper
     * object linking, and is public for that reason.
     *
     * @param ObjectStateInterface $parent
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
        $out = array(
            'hash' => $this->generateHash(),
            'dynamic' => $this->isDynamic(),
        );

        foreach ($this->__sleep() as $param) {
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
        return array('name', 'presentation', 'type', 'extras');
    }
}
