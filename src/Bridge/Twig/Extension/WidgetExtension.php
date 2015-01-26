<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bridge\Twig\Extension;

use Twig_Extension;
use Twig_Environment;
use Twig_SimpleFunction;
use Accard\Bridge\Twig\TokenParser\WidgetThemeTokenParser;
use Accard\Bridge\Twig\Widget\TwigRendererInterface;
use Accard\Component\Widget\Grid\Grid;
use Accard\Component\Widget\Grid\GridBuilder;
use Accard\Component\Widget\Grid\GridProvider;
//use Symfony\Component\Widget\Extension\Core\View\ChoiceView;

/**
 * Widget Twig extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetExtension extends Twig_Extension
{
    /**
     * Renderer.
     *
     * Public to slightly increase performance while rendering.
     *
     * @var TwigRendererInterface
     */
    public $renderer;

    /**
     * Grid Provider
     */
    public $gridProvider;

    /**
     * Constructor.
     *
     * @param TwigRendererInterface $renderer
     */
    public function __construct(TwigRendererInterface $renderer, 
                                GridProvider $gridProvider)
    {
        $this->renderer = $renderer;
        $this->gridProvider = $gridProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(Twig_Environment $environment)
    {
        $this->renderer->setEnvironment($environment);
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return array(
            // {% widget_theme widget "SomeBundle::widgets.twig" %}
            new WidgetThemeTokenParser(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('widget', null, array('node_class' => 'Accard\Bridge\Twig\Node\SearchAndRenderBlockNode', 'is_safe' => array('html'))),
            //createCanvas needs some type of node
            new Twig_SimpleFunction('canvas', array($this, 'createCanvas'), array('is_safe' => array('html', 'js'))),
        );
    }

    public function createCanvas($defaultGridLayout, $storedGridIdentifier, $data)
    {
        return $this->gridProvider->createCanvas($defaultGridLayout, $storedGridIdentifier, $data);
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'widget';
    }
}
