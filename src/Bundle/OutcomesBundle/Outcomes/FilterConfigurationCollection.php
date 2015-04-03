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

use ArrayAccess;
use IteratorAggregate;
use ArrayIterator;

/**
 * Filter configuration collection.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FilterConfigurationCollection implements ArrayAccess, IteratorAggregate
{
    /**
     * Filter filters.
     *
     * @var array
     */
    protected $filters = array();


    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->filters[] = $value;
        } else {
            $this->filters[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->filters[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->filters[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return isset($this->filters[$offset]) ? $this->filters[$offset] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->filters);
    }
}
