<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bridge\Twig\Node;

use Twig_Node;
use Twig_NodeInterface;
use Twig_Compiler;

/**
 * Widget theme node.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetThemeNode extends Twig_Node
{
	/**
	 * Constructor.
	 *
	 * @param Twig_NodeInterface $widget
	 * @param Twig_NodeInterface $resources
	 * @param integer $lineno
	 * @param string|null $tag
	 */
    public function __construct(Twig_NodeInterface $widget, Twig_NodeInterface $resources, $lineno, $tag = null)
    {
        parent::__construct(array('widget' => $widget, 'resources' => $resources), array(), $lineno, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('$this->env->getExtension(\'widget\')->renderer->setTheme(')
            ->subcompile($this->getNode('widget'))
            ->raw(', ')
            ->subcompile($this->getNode('resources'))
            ->raw(");\n");
    }
}
