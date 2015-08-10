<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Information controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class InfoController extends Controller
{
    /**
     * State documentation action.
     *
     * @return Response
     */
    public function stateAction()
    {
        return $this->render('AccardCoreBundle:Info:state.html.twig', array(
            'state' => $this->get('accard.state')->getState()
        ));
    }
}
