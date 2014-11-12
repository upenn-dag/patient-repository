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

use Traversable;
use Countable;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\ImmutableEventDispatcher;
use Accard\Component\Widget\Exception\BadMethodCallException;
use Accard\Component\Widget\Exception\InvalidArgumentException;
use Accard\Component\Widget\Exception\UnexpectedTypeException;

/**
 * Widget builder interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetBuilderInterface extends Traversable, Countable, WidgetConfigBuilderInterface
{
    /**
     * Add a widget.
     *
     * @param string|FormBuilderInterface $child
     * @param string|FormTypeInstance $type
     * @param array $otions
     * @return FormBuilderInterface
     */
    public function add($child, $type = null, array $options = array());

    /**
     * Create a widget builder.
     *
     * @param string $name
     * @param string|FormTypeInterface $type
     * @param array $options
     * @return FormBuilderInterface
     */
    public function create($name, $type = null, array $options = array());

    /**
     * Get child by name.
     *
     * @throws InvalidArgumentException If the child does not exist.
     * @param string $name
     * @return FormBuilderInterface
     */
    public function get($name);

    /**
     * Remove child by name.
     *
     * @param string $name
     * @return FormBuilderInterface
     */
    public function remove($name);

    /**
     * Test if child exists.
     *
     * @param string $name
     * @return boolean
     */
    public function has($name);

    /**
     * Get all children.
     *
     * @return array
     */
    public function all();

    /**
     * Get the widget.
     *
     * @return Widget
     */
    public function getWidget();
}
