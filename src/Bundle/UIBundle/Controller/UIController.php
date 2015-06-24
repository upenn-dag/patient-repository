<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\UIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * UI Controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class UIController extends Controller
{
    public function mainAction(Request $request)
    {
        return $this->render('AccardUIBundle:Frontend:main.html.twig');
    }

    public function deletedAction(Request $request, $type, $id)
    {
        return $this->render('AccardUIBundle:Frontend:deleted.html.twig', array(
            'type' => $type,
            'id' => $id
        ));
    }
}
