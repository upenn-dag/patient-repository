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
 * Abstract widget rendering engine.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class AbstractRendererEngine implements WidgetRendererEngineInterface
{
    const CACHE_KEY_VAR = 'cache_key';

    /**
     * Default themes.
     *
     * @var array
     */
    protected $defaultThemes;

    /**
     * Themes.
     *
     * @var array
     */
    protected $themes = array();

    /**
     * Resources.
     *
     * @var array
     */
    protected $resources = array();

    /**
     * Resource hierarchy levels.
     *
     * @var array
     */
    private $resourceHierarchyLevels = array();

    /**
     * Constructor.
     *
     * @param array $defaultThemes
     */
    public function __construct(array $defaultThemes = array())
    {
        $this->defaultThemes = $defaultThemes;
    }

    /**
     * {@inheritdoc}
     */
    public function setTheme(WidgetView $view, $themes)
    {
        $cacheKey = $view->vars[self::CACHE_KEY_VAR];
        $this->themes[$cacheKey] = is_array($themes) ? $themes : array($themes);
        unset($this->resources[$cacheKey]);
        unset($this->resourceHierarchyLevels[$cacheKey]);
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceForBlockName(WidgetView $view, $blockName)
    {
        $cacheKey = $view->vars[self::CACHE_KEY_VAR];

        if (!isset($this->resources[$cacheKey][$blockName])) {
            $this->loadResourceForBlockName($cacheKey, $view, $blockName);
        }

        return $this->resources[$cacheKey][$blockName];
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceForBlockNameHierarchy(WidgetView $view, array $blockHierarchy, $level)
    {
        $cacheKey = $view->vars[self::CACHE_KEY_VAR];
        $blockName = $blockHierarchy[$level];

        if (!isset($this->resources[$cacheKey][$blockName])) {
            $this->loadResourceForBlockNameHierarchy($cacheKey, $view, $blockHierarchy, $level);
        }

        return $this->resources[$cacheKey][$blockName];
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceHierarchyLevel(WidgetView $view, array $blockHierarchy, $level)
    {
        $cacheKey = $view->vars[self::CACHE_KEY_VAR];
        $blockName = $blockHierarchy[$level];

        if (!isset($this->resources[$cacheKey][$blockName])) {
            $this->loadResourceForBlockNameHierarchy($cacheKey, $view, $blockHierarchy, $level);
        }

        if (!isset($this->resourceHierarchyLevels[$cacheKey][$blockName])) {
            $this->resourceHierarchyLevels[$cacheKey][$blockName] = $level;
        }

        return $this->resourceHierarchyLevels[$cacheKey][$blockName];
    }

    /**
     * Loads the cache with the resource for a given block name.
     *
     * @param string $cacheKey
     * @param WidgetView $view
     * @param string $blockName
     * @return boolean
     */
    abstract protected function loadResourceForBlockName($cacheKey, WidgetView $view, $blockName);

    /**
     * Loads the cache with the resource for a specific level of a block hierarchy.
     *
     * @param string $cacheKey
     * @param WidgetView $view
     * @param array $blockHierarchy
     * @param int $level
     * @return boolean
     */
    private function loadResourceForBlockNameHierarchy($cacheKey, WidgetView $view, array $blockHierarchy, $level)
    {
        $blockName = $blockHierarchy[$level];

        if ($this->loadResourceForBlockName($cacheKey, $view, $blockName)) {
            $this->resourceHierarchyLevels[$cacheKey][$blockName] = $level;

            return true;
        }

        if ($level > 0) {
            $parentLevel = $level - 1;
            $parentBlockName = $blockHierarchy[$parentLevel];

            if (isset($this->resources[$cacheKey][$parentBlockName])) {
                if (!isset($this->resourceHierarchyLevels[$cacheKey][$parentBlockName])) {
                    $this->resourceHierarchyLevels[$cacheKey][$parentBlockName] = $parentLevel;
                }

                $this->resources[$cacheKey][$blockName] = $this->resources[$cacheKey][$parentBlockName];
                $this->resourceHierarchyLevels[$cacheKey][$blockName] = $this->resourceHierarchyLevels[$cacheKey][$parentBlockName];

                return true;
            }

            if ($this->loadResourceForBlockNameHierarchy($cacheKey, $view, $blockHierarchy, $parentLevel)) {
                $this->resources[$cacheKey][$blockName] = $this->resources[$cacheKey][$parentBlockName];
                $this->resourceHierarchyLevels[$cacheKey][$blockName] = $this->resourceHierarchyLevels[$cacheKey][$parentBlockName];

                return true;
            }
        }

        $this->resources[$cacheKey][$blockName] = false;
        $this->resourceHierarchyLevels[$cacheKey][$blockName] = false;

        return false;
    }
}
