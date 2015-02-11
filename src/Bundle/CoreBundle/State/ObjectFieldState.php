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

/**
 * Accard field state representation.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ObjectFieldState extends ObjectStaticFieldState
{
    public $allowMultiple;
    public $addable;
    public $configuration;
    public $option;
    public $extras = array();


    /**
     * {@inheritdoc}
     */
    public function isDynamic()
    {
        return true;
    }

    /**
     * Set field allows multiple.
     *
     * @param boolean $allowMultiple
     * @return self
     */
    public function setAllowMultiple($allowMultiple)
    {
        $this->allowMultiple = $allowMultiple;

        return $this;
    }

    /**
     * Set field is addable.
     *
     * @param boolean $addable
     * @return self
     */
    public function setAddable($addable)
    {
        $this->addable = $addable;

        return $this;
    }

    /**
     * Set field configuration array.
     *
     * @param array $configuration
     * @return self
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * Set field option.
     *
     * @param integer|null $option
     * @return self
     */
    public function setOption($option = null)
    {
        $this->option = $option;

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
     * {@inheritdoc}
     */
    public function __sleep()
    {
        return array('name', 'presentation', 'type', 'allowMultiple', 'addable', 'configuration', 'option', 'extras');
    }
}
