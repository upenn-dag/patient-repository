<?php
/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CanvasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class CanvasController
 *
 * @author Dylan Pierce <piercedy@med.upenn.edu>
 * @package Accard\Bundle\CanvasBundle\Controller
 */

class CanvasController extends Controller
{
    private $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function designAction()
    {
        return $this->templating->renderResponse('AccardWebBundle:Backend/Canvas:design.html.twig');
    }

    public function gridAction()
    {
        $response = new JsonResponse();
        $response->setData(array(
            'data' => 123
        ));

        return $response;
    }
}
