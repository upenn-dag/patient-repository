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
use Accard\Component\Widget\WidgetRenderer;
use Accard\Component\Widget\Exception\UnexpectedTypeException;

/**
 * Twig widget renderer.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TwigRenderer extends WidgetRenderer implements TwigRendererInterface
{
    /**
     * Constructor.
     *
     * @param TwigRendererEngineInterface $engine
     */
    public function __construct(TwigRendererEngineInterface $engine)
    {
        parent::__construct($engine);
    }

    /**
     * {@inheritdoc}
     */
    public function setEnvironment(Twig_Environment $environment)
    {
        $this->engine->setEnvironment($environment);
    }
}
