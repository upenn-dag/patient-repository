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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Resolved widget type interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ResolvedWidgetTypeInterface
{
    /**
     * Get inner name.
     *
     * @var string
     */
    public function getName();

    /**
     * Get parent builder.
     *
     * @var ResolvedWidgetTypeInterface|null
     */
    public function getParent();

    /**
     * Get inner type.
     *
     * @var WidgetTypeInterface
     */
    public function getInnerType();

    /**
     * Create builder.
     *
     * @param WidgetFactoryInterface $factory
     * @param string $name
     * @param array $options
     * @return WidgetBuilder
     */
    public function createBuilder(WidgetFactoryInterface $factory, $name, array $options = array());

    /**
     * Create view.
     *
     * @param WidgetInterface $widget
     * @param WidgetView|null $parent
     * @return WidgetView
     */
    public function createView(WidgetInterface $widget, WidgetView $parent = null);

    /**
     * Build view.
     *
     * @param WidgetView $view
     * @param WidgetInterface $widget
     * @param array $options
     */
    public function buildView(WidgetView $view, WidgetInterface $widget, array $options);

    /**
     * Finish view.
     *
     * @param WidgetView $view
     * @param WidgetInterface $widget
     * @param array $options
     */
    public function finishView(WidgetView $view, WidgetInterface $widget, array $options);

    /**
     * Get options resolver.
     *
     * @return OptionsResolverInterface
     */
    public function getOptionsResolver();
}
