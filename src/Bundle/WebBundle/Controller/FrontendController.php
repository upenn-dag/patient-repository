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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Base frontend controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FrontendController extends Controller
{
    /**
     * Frontend homepage action.
     *
     * @var Response
     */
    public function mainAction(Request $request)
    {
        // $domain = $this->get('accard.expression_language');
        // $return = $domain->evaluate('count(slice(patient("000000000").getDiagnoses(), 1))');
        // die(var_dump($return));

        return $this->render('AccardWebBundle:Frontend:main.html.twig');
    }

    /**
     * Render filter form.
     *
     * @param string $type
     * @param string $template
     * @return Response
     */
    public function filterAction($type, $template)
    {
        $request = $this->get('request_stack')->getMasterRequest();
        $criteria = $request->query->get('criteria', array());
        $form = $this
            ->get('form.factory')
            ->createNamed('criteria', $type, $criteria, array('csrf_protection' => false));

        return $this->render($template, array('form' => $form->createView(), 'filter_criteria' => $criteria));
    }
}
