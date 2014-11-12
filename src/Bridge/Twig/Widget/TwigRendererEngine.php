<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bridge\Twig\Widget;

use Twig_Environment;
use Twig_Template;
use Accard\Component\Widget\AbstractRendererEngine;
use Accard\Component\Widget\WidgetView;

/**
 * Twig widget renderer engine.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TwigRendererEngine extends AbstractRendererEngine implements TwigRendererEngineInterface
{
    /**
     * Twig environment.
     *
     * @var Twig_Environment
     */
    private $environment;

    /**
     * Twig template.
     *
     * @var Twig_Template
     */
    private $template;


    /**
     * {@inheritdoc}
     */
    public function setEnvironment(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    public function renderBlock(WidgetView $view, $resource, $blockName, array $vars = array())
    {
        $cacheKey = $view->vars[self::CACHE_KEY_VAR];
        $context = $this->environment->mergeGlobals($vars);
        ob_start();
        $this->template->displayBlock($blockName, $context, $this->resources[$cacheKey]);

        return ob_get_clean();
    }

    /**
     * {@inheritdoc}
     */
    protected function loadResourceForBlockName($cacheKey, WidgetView $view, $blockName)
    {
        if (isset($this->resources[$cacheKey])) {
            $this->resources[$cacheKey][$blockName] = false;

            return false;
        }

        if (isset($this->themes[$cacheKey])) {
            for ($i = count($this->themes[$cacheKey]) - 1; $i >= 0; --$i) {
                $this->loadResourcesFromTheme($cacheKey, $this->themes[$cacheKey][$i]);
            }
        }

        if (!$view->parent) {
            for ($i = count($this->defaultThemes) - 1; $i >= 0; --$i) {
                $this->loadResourcesFromTheme($cacheKey, $this->defaultThemes[$i]);
            }
        }

        if ($view->parent) {
            $parentCacheKey = $view->parent->vars[self::CACHE_KEY_VAR];

            if (!isset($this->resources[$parentCacheKey])) {
                $this->loadResourceForBlockName($parentCacheKey, $view->parent, $blockName);
            }

            foreach ($this->resources[$parentCacheKey] as $nestedBlockName => $resource) {
                if (!isset($this->resources[$cacheKey][$nestedBlockName])) {
                    $this->resources[$cacheKey][$nestedBlockName] = $resource;
                }
            }
        }

        if (!isset($this->resources[$cacheKey][$blockName])) {
            $this->resources[$cacheKey][$blockName] = false;
        }

        return false !== $this->resources[$cacheKey][$blockName];
    }

    /**
     * {@inheritdoc}
     */
    protected function loadResourcesFromTheme($cacheKey, &$theme)
    {
        if (!$theme instanceof Twig_Template) {
            $theme = $this->environment->loadTemplate($theme);
        }

        if (null === $this->template) {
            $this->template = $theme;
        }

        $currentTheme = $theme;
        $context = $this->environment->mergeGlobals(array());

        do {
            foreach ($currentTheme->getBlocks() as $block => $blockData) {
                if (!isset($this->resources[$cacheKey][$block])) {
                    $this->resources[$cacheKey][$block] = $blockData;
                }
            }
        } while (false !== $currentTheme = $currentTheme->getParent($context));
    }
}
