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

use Accard\Component\Widget\Exception\LogicException;
use Accard\Component\Widget\Exception\BadMethodCallException;
use Accard\Component\Widget\Exception\UnexpectedTypeException;

/**
 * Renders a widget into HTML via a rendering engine.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetRenderer implements WidgetRendererInterface
{
    const CACHE_KEY_VAR = 'unique_block_prefix';

    /**
     * Rendering engine.
     *
     * @var WidgetRendererEngineInterface
     */
    protected $engine;

    /**
     * Block name hierarchy map.
     *
     * @var array
     */
    private $blockNameHierarchyMap = array();

    /**
     * Block hierarchy level map.
     *
     * @var array
     */
    private $hierarchyLevelMap = array();

    /**
     * Variable stack.
     *
     * @var array
     */
    private $varStack = array();


    /**
     * Constructor.
     *
     * @param WidgetRendererEngineInterface $engine
     */
    public function __construct(WidgetRendererEngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * {@inheritdoc}
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * {@inheritdoc}
     */
    public function setTheme(WidgetView $view, $themes)
    {
        $this->engine->setTheme($view, $themes);
    }

    /**
     * {@inheritdoc}
     */
    public function renderBlock(WidgetView $view, $blockName, array $vars = array())
    {
        if (!$resource = $this->engine->getResourceForBlockName($view, $blockName)) {
            throw new LogicException(sprintf('No block "%s" found while rendering the widget.', $blockName));
        }

        $viewCacheKey = $view->vars[self::CACHE_KEY_VAR];

        if (!isset($this->varStack[$viewCacheKey])) {
            $this->varStack[$viewCacheKey] = array();
            $scopeVars = $view->vars;
            $varInit = true;
        } else {
            $scopeVars = end($this->varStack[$viewCacheKey]);
            $varInit = false;
        }

        if (isset($vars['attr']) && isset($scopeVars['attr'])) {
            $vars['attr'] = array_replace($scopeVars['attr'], $vars['attr']);
        }

        $vars = array_replace($scopeVars, $vars);
        $this->varStack[$viewCacheKey][] = $vars;
        $html = $this->engine->renderBlock($view, $resource, $blockName, $vars);

        array_pop($this->varStack[$viewCacheKey]);

        if ($varInit) {
            unset($this->varStack[$viewCacheKey]);
        }

        return $html;
    }

    /**
     * {@inheritdoc}
     */
    public function searchAndRenderBlock(WidgetView $view, $blockSuffix, array $vars = array())
    {
        $renderOnlyOnce = 'widget' === $blockSuffix;

        if ($renderOnlyOnce && $view->isRendered()) {
            return '';
        }

        $viewCacheKey = $view->vars[self::CACHE_KEY_VAR];
        $viewAndSuffixCacheKey = $viewCacheKey.$blockSuffix;

        if (!isset($this->blockNameHierarchyMap[$viewAndSuffixCacheKey])) {
            $blockNameHierarchy = array();
            foreach ($view->vars['block_prefixes'] as $blockNamePrefix) {
                $blockNameHierarchy[] = $blockNamePrefix.'_'.$blockSuffix;
            }
            $hierarchyLevel = count($blockNameHierarchy) - 1;
            $hierarchyInit = true;
        } else {
            $blockNameHierarchy = $this->blockNameHierarchyMap[$viewAndSuffixCacheKey];
            $hierarchyLevel = $this->hierarchyLevelMap[$viewAndSuffixCacheKey] - 1;
            $hierarchyInit = false;
        }

        if (!isset($this->varStack[$viewCacheKey])) {
            $this->varStack[$viewCacheKey] = array();
            $scopeVars = $view->vars;
            $varInit = true;
        } else {
            $scopeVars = end($this->varStack[$viewCacheKey]);
            $varInit = false;
        }

        $resource = $this->engine->getResourceForBlockNameHierarchy($view, $blockNameHierarchy, $hierarchyLevel);
        $hierarchyLevel = $this->engine->getResourceHierarchyLevel($view, $blockNameHierarchy, $hierarchyLevel);
        $blockName = $blockNameHierarchy[$hierarchyLevel];

        if (!$resource) {
            throw new LogicException(sprintf(
                'Unable to render the widget as none of the following blocks exist: "%s".',
                implode('", "', array_reverse($blockNameHierarchy))
            ));
        }

        if (isset($vars['attr']) && isset($scopeVars['attr'])) {
            $vars['attr'] = array_replace($scopeVars['attr'], $vars['attr']);
        }

        $vars = array_replace($scopeVars, $vars);
        $this->blockNameHierarchyMap[$viewAndSuffixCacheKey] = $blockNameHierarchy;
        $this->hierarchyLevelMap[$viewAndSuffixCacheKey] = $hierarchyLevel;
        $this->varStack[$viewCacheKey][] = $vars;
        $html = $this->engine->renderBlock($view, $resource, $blockName, $vars);

        array_pop($this->varStack[$viewCacheKey]);

        if ($hierarchyInit) {
            unset($this->blockNameHierarchyMap[$viewAndSuffixCacheKey]);
            unset($this->hierarchyLevelMap[$viewAndSuffixCacheKey]);
        }

        if ($varInit) {
            unset($this->varStack[$viewCacheKey]);
        }

        if ($renderOnlyOnce) {
            $view->setRendered();
        }

        return $html;
    }
}
