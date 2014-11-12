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

/**
 * Widget config builder interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetConfigBuilderInterface extends WidgetConfigInterface
{
    /**
     * Set widget type.
     *
     * @param ResolvedWidgetTypeInterface $type
     * @return self
     */
    public function setType(ResolvedWidgetTypeInterface $type);

    /**
     * Set compound.
     *
     * @param boolean $compound
     * @return self
     */
    public function setCompound($compound);

    /**
     * Set inherit data.
     *
     * @param boolean $inheritData
     * @return WidgetConfigBuilderInterface
     */
    public function setInheritData($inheritData);

    /**
     * Set empty data.
     *
     * @param mixed $emptyData
     * @return WidgetConfigBuilderInterface
     */
    public function setEmptyData($emptyData);

    /**
     * Set data.
     *
     * @param mixed $data
     * @return WidgetConfigBuilderInterface
     */
    public function setData($data);

    /**
     * Set form factory.
     *
     * @param WidgetFactoryInterface $formFactory
     * @return self
     */
    public function setWidgetFactory(WidgetFactoryInterface $formFactory);

    /**
     * Set auto initialize.
     *
     * @param boolean $autoInitialize
     * @return WidgetBuilderInterface
     */
    public function setAutoInitialize($autoInitialize);

    /**
     * Add event listener.
     *
     * @param string $eventName
     * @param callable $listener
     * @param integer $priority
     * @return WidgetBuilderInterface
     */
    public function addEventListener($eventName, $listener, $priority = 0);

    /**
     * Add event subscriber.
     *
     * @param EventSubscriberInterface
     * @return WidgetBuilderInterface
     */
    public function addEventSubscriber(EventSubscriberInterface $subscriber);

    /**
     * Set attribtue.
     *
     * @param string $name
     * @param mixed $value
     * @return WidgetBuilderInterface
     */
    public function setAttribute($name, $value);

    /**
     * Set attributes.
     *
     * @param array $attributes
     * @return WidgetBuilderInterface
     */
    public function setAttributes(array $attributes);

    /**
     * Build and get widget configuration.
     *
     * @return WidgetBuilderInterface
     */
    public function getWidgetConfig();
}
