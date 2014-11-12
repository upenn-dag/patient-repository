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
 * Renders a widget into HTML.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetRendererInterface
{
    /**
     * Get the rendering engine.
     *
     * @return WidgetRendererEngineInterface
     */
    public function getEngine();

    /**
     * Set the rendered theme for a view.
     *
     * @param WidgetView $view
     * @param mixed $themes
     */
    public function setTheme(WidgetView $view, $themes);

    /**
     * Renders a named block of a widget theme.
     *
     * @param WidgetView $view
     * @param string $blockName
     * @param array $vars
     * @return string
     */
    public function renderBlock(WidgetView $view, $blockName, array $vars = array());

    /**
     * Search and render a block for a given suffix.
     *
     * @param WidgetView $view
     * @param string $blockSuffix
     * @param array $vars
     * @return string
     */
    public function searchAndRenderBlock(WidgetView $view, $blockSuffix, array $vars = array());
}
