<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bridge\Twig\TokenParser;

use Twig_Token;
use Twig_TokenParser;
use Accard\Bridge\Twig\Node\WidgetThemeNode;

/**
 * Widget theme token parser.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetThemeTokenParser extends Twig_TokenParser
{
    /**
     * {@inheritdoc}
     */
    public function parse(Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $widget = $this->parser->getExpressionParser()->parseExpression();

        if ($this->parser->getStream()->test(Twig_Token::NAME_TYPE, 'with')) {
            $this->parser->getStream()->next();
            $resources = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $resources = new \Twig_Node_Expression_Array(array(), $stream->getCurrent()->getLine());
            do {
                $resources->addElement($this->parser->getExpressionParser()->parseExpression());
            } while (!$stream->test(Twig_Token::BLOCK_END_TYPE));
        }

        $stream->expect(Twig_Token::BLOCK_END_TYPE);

        return new WidgetThemeNode($widget, $resources, $lineno, $this->getTag());
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return 'widget_theme';
    }
}
