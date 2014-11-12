<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license inwidgetation, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Widget;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Widget type interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetTypeInterface
{
    /**
     * Builds the widget.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type.
     *
     * @param WidgetBuilderInterface $builder
     * @param array $options The options
     */
    public function buildWidget(WidgetBuilderInterface $builder, array $options);

    /**
     * Builds the widget view.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type.
     *
     * A view of a widget is built before the views of the child widgets are built.
     * This means that you cannot access child views in this method. If you need
     * to do so, move your logic to {@link finishView()} instead.
     *
     * @param WidgetView $view
     * @param WidgetInterface $widget
     * @param array $options
     */
    public function buildView(WidgetView $view, WidgetInterface $widget, array $options);

    /**
     * Finishes the widget view.
     *
     * This method gets called for each type in the hierarchy starting from the
     * top most type.
     *
     * When this method is called, views of the widget's children have already
     * been built and finished and can be accessed. You should only implement
     * such logic in this method that actually accesses child views. For everything
     * else you are recommended to implement {@link buildView()} instead.
     *
     * @param WidgetView $view
     * @param WidgetInterface $widget
     * @param array $options
     */
    public function finishView(WidgetView $view, WidgetInterface $widget, array $options);

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver);

    /**
     * Get parent.
     *
     * @return string|null
     */
    public function getParent();

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();
}
