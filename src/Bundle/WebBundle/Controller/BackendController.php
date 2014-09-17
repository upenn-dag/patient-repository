<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BackendController extends Controller
{
    /**
     * Backend dashboard action.
     *
     * @var Response
     */
    public function dashboardAction()
    {
        return $this->render('AccardWebBundle:Backend:dashboard.html.twig');
    }
}
