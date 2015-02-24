<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Accard outcomes controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OutcomesController extends Controller
{
	/**
	 * Outcomes main.
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function mainAction(Request $request)
	{
		return $this->render('AccardOutcomesBundle::main.html.twig');
	}
}
