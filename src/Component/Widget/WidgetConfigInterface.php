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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Widget config interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetConfigInterface
{
    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get type.
     *
     * @return ResolvedWidgetTypeInterface
     */
    public function getType();

    /**
     * Get whether widget is compound.
     *
     * @return boolean
     */
    public function getCompound();

    /**
     * Get whether widget should inherit data from its parent.
     *
     * @return boolean
     */
    public function getInheritData();

    /**
     * Get data for when widget is empty.
     *
     * @return mixed
     */
    public function getEmptyData();

    /**
     * Get initial data for widget.
     *
     * @return mixed
     */
    public function getData();

    /**
     * Get auto initalize.
     *
     * @return boolean
     */
    public function getAutoInitialize();

    /**
     * Get form factory.
     *
     * @return WidgetFactoryInterface
     */
    public function getWidgetFactory();

    /**
     * Get event dispatcher.
     *
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher();

    /**
     * Get attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Test for presence of attribute.
     *
     * @param string $name
     * @return boolean
     */
    public function hasAttribute($name);

    /**
     * Get attribute (or default).
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($name, $default = null);

    /**
     * Get options.
     *
     * @return array
     */
    public function getOptions();

    /**
     * Test for presence of option.
     *
     * @param string $name
     * @return boolean
     */
    public function hasOption($name);

    /**
     * Get option (or default).
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getOption($name, $default = null);
}
