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

/**
 * Compiles a call to {@link WidgetRendererInterface::renderBlock()}.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RenderBlockNode extends Twig_Node_Expression_Function
{
    /**
     * {@inheritdoc}
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);
        $arguments = iterator_to_array($this->getNode('arguments'));
        $compiler->write('$this->env->getExtension(\'widget\')->renderer->renderBlock(');

        if (isset($arguments[0])) {
            $compiler->subcompile($arguments[0]);
            $compiler->raw(', \''.$this->getAttribute('name').'\'');

            if (isset($arguments[1])) {
                $compiler->raw(', ');
                $compiler->subcompile($arguments[1]);
            }
        }

        $compiler->raw(')');
    }
}
