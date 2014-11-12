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

use Twig_Compiler;
use Twig_Node_Expression_Function;
use Twig_Node_Expression_Constant;

/**
 * Compiles a call to {@link WidgetRendererInterface::renderBlock()}.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SearchAndRenderBlockNode extends Twig_Node_Expression_Function
{
    /**
     * {@inheritdoc}
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);
        $compiler->raw('$this->env->getExtension(\'widget\')->renderer->searchAndRenderBlock(');

        preg_match('/_([^_]+)$/', $this->getAttribute('name'), $matches);

        $arguments = iterator_to_array($this->getNode('arguments'));
        $blockNameSuffix = empty($matches) ? 'widget' : $matches[1];

        if (isset($arguments[0])) {
            $compiler->subcompile($arguments[0]);
            $compiler->raw(', \''.$blockNameSuffix.'\'');

            if (isset($arguments[1])) {
                if (null !== $variables) {
                    $compiler->raw(', ');

                    if (null !== $variables) {
                        $compiler->subcompile($arguments[1]);
                    }
                }
            }
        }

        $compiler->raw(")");
    }
}
