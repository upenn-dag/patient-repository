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
use Accard\Component\Widget\WidgetRendererEngineInterface;

/**
 * Twig widget rendering engine.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface TwigRendererEngineInterface
{
    /**
     * Set Twig environment.
     *
     * @param Twig_Environment $environment
     */
    public function setEnvironment(Twig_Environment $environment);
}
