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
 * Widget factory builder interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetFactoryBuilderInterface
{
    /**
     * Set resolved widget type factory.
     *
     * @param ResolvedWidgetTypeFactoryInterface $resolvedTypeFactory
     * @return WidgetFactoryBuilderInterface
     */
    public function setResolvedTypeFactory(ResolvedWidgetTypeFactoryInterface $resolvedTypeFactory);

    /**
     * Get widget factory.
     *
     * @return WidgetFactoryInterface
     */
    public function getFactory();

    /**
     * Add widget extension.
     *
     * @param WidgetExtensionInterface $extension
     * @return WidgetFactoryBuilderInterface
     */
    public function addExtension(WidgetExtensionInterface $extension);

    /**
     * Add array of widget extensions.
     *
     * @param WidgetExtensionInterface[] $extensions
     * @return WidgetFactoryBuilderInterface
     */
    public function addExtensions(array $extensions);

    /**
     * Add widget type.
     *
     * @param WidgetTypeInterface $type
     * @return WidgetFactoryBuilderInterface
     */
    public function addType(WidgetTypeInterface $type);

    /**
     * Add array of widget types.
     *
     * @param WidgetTypeInterface[] $types
     * @return WidgetFactoryBuilderInterface
     */
    public function addTypes(array $types);
}
