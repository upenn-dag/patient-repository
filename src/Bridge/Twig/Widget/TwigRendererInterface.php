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
use Accard\Component\Widget\WidgetRendererInterface;

/**
 * Twig widget renderer.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface TwigRendererInterface extends WidgetRendererInterface
{
    /**
     * Set Twig environment.
     *
     * @param Twig_Environment $environment
     */
    public function setEnvironment(Twig_Environment $environment);
}
