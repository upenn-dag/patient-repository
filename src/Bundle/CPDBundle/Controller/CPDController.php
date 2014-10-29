<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PDSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManager;

/**
 * CPD controller.
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class CPDController extends Controller
{
    /**
     * Patient action.
     * 
     * @param string $mrn
     * @return JsonResponse
     */
    public function resultsAction($mrn)
    {
        $mrn = (int) $mrn;
        $patient = $this->getPatients()->findOneByMrn($mrn);

        $response = new JsonResponse();
        $response->setData($patient);

        return $response;
    }

    private function getOptionProvider()
    {
        return $this->get('accard.provider.option');
    }

    private function getPatients()
    {
        return $this->getDoctrine()->getManager('accard')->getRepository("AccardCPDBundle:Patient");
    }

}
