<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Widget;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Countable;
use Accard\Component\Widget\Exception\BadMethodCallException;

/**
 * Widget view.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetView implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * Variables.
     *
     * @var array
     */
    public $vars = array('attr' => array());

    /**
     * Parent view.
     *
     * @var WidgetView
     */
    public $parent;

    /**
     * Child views.
     *
     * @var WidgetView[]
     */
    public $children = array();

    /**
     * Is the widget attached to this renderer rendered?
     *
     * Rendering happens when either the widget or the row method was called.
     * Row implicitly includes widget, however certain rendering mechanisms
     * have to skip widget rendering when a row is rendered.
     *
     * @var bool
     */
    private $rendered = false;


    /**
     * Constructor.
     *
     * @param WidgetView|null $parent
     */
    public function __construct(WidgetView $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Test if the view was already rendered.
     *
     * @return boolean
     */
    public function isRendered()
    {
        $hasChildren = 0 < count($this->children);

        if (true === $this->rendered || !$hasChildren) {
            return $this->rendered;
        }

        if ($hasChildren) {
            foreach ($this->children as $child) {
                if (!$child->isRendered()) {
                    return false;
                }
            }

            return $this->rendered = true;
        }

        return false;
    }

    /**
     * Marks the view as rendered.
     *
     * @return WidgetView The view object.
     */
    public function setRendered()
    {
        $this->rendered = true;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($name)
    {
        return $this->children[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($name)
    {
        return isset($this->children[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($name, $value)
    {
        throw new BadMethodCallException('Not supported');
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($name)
    {
        unset($this->children[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->children);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->children);
    }
}
