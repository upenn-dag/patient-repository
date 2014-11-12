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
 * Templating engine to form rendering adapter.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetRendererEngineInterface
{
    /**
     * Set theme for rendering a widget.
     *
     * @param WidgetView $view
     * @param mixed $themes
     */
    public function setTheme(WidgetView $view, $themes);

    /**
     * Get the resource for a block name.
     *
     * @param WidgetView $view
     * @param string $blockName
     * @return mixed|false
     */
    public function getResourceForBlockName(WidgetView $view, $blockName);

    /**
     * Get the resource for a block hierarchy.
     *
     * @param WidgetView $view
     * @param array $blockHierarchy
     * @param integer $level
     * @return mixed|false
     */
    public function getResourceForBlockNameHierarchy(WidgetView $view, array $blockHierarchy, $level);

    /**
     * Get resource hierarchy level.
     *
     * @param WidgetView $view
     * @param array $blockHierarchy
     * @param integer $level
     * @return integer|boolean
     */
    public function getResourceHierarchyLevel(WidgetView $view, array $blockHierarchy, $level);

    /**
     * Render block in renderer resource.
     *
     * @param WidgetView $view
     * @param mixed $resource
     * @param string $blockName
     * @param array $vars
     * @return string
     */
    public function renderBlock(WidgetView $view, $resource, $blockName, array $vars = array());
}
