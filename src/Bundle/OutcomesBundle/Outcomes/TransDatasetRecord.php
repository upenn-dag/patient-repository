<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Outcomes;

use ArrayIterator;
use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * Translated dataset record.
 *
 * Keys are public for speed and serialization purposes.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TransDatasetRecord implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * Record value.
     *
     * @var array
     */
    public $values;


    /**
     * Constructor.
     *
     * @param mixed|null $value
     */
    public function __construct(array $values = array())
    {
        $this->set($values);
    }

    /**
     * Add record value.
     *
     * @param string $key
     * @param mixed|null $key
     */
    public function add($key, $value = null)
    {
        $this->values[$key] = $value;

        return $this;
    }

    /**
     * Get all values.
     *
     * @return array
     */
    public function all()
    {
        return $this->values;
    }

    /**
     * Get record values.
     *
     * @return array
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            throw new \InvalidArgumentException("Unable to locate key.");
        }

        return $this->values[$key];
    }

    /**
     * Test for presence of record value.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return isset($this->values[$key]);
    }

    /**
     * Get record keys.
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->values);
    }

    /**
     * Remove a value by key.
     *
     * @param string $key
     */
    public function remove($key)
    {
        if (!$this->has($key)) {
            throw new \InvalidArgumentException("Unable to locate key.");
        }

        unset($this->values[$key]);
    }

    /**
     * Set record values.
     *
     * @param array $values
     * @return self
     */
    public function set(array $values)
    {
        foreach ($values as $key => $value) {
            $this->add($key, $value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->values);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->values);
    }


    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }
}
