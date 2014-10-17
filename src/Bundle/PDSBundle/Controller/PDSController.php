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
 * Penn Data Store controller.
 * 
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PDSController extends Controller
{
    /**
     * Patient action.
     * 
     * @param string $mrn
     * @return JsonResponse
     */
    public function patientAction($mrn)
    {
        $mrn = (int) $mrn;
        $patient = $this->getPatients()->findOneByMrn($mrn);

        $response = new JsonResponse();
        $response->setData($patient);

        return $response;
    }

    public function jsAction()
    {
        $provider = $this->getOptionProvider();
        $genders = $provider->getOptionByName('gender')->getValues();
        $races = $provider->getOptionByName('race')->getValues();

        foreach ($genders as $gender) {
            $begin = strtolower(substr($gender->getValue(), 0, 1));
            switch ($begin) {
                case 'm': $male = $gender->getId(); break;
                case 'f': $female = $gender->getId(); break;
                case 'u': $unknown = $gender->getId(); break;
            }
        }

        foreach ($races as $race) {
            $begin = strtolower(substr($race->getValue(), 0, 3));
            switch ($begin) {
                case 'ame':
                case 'ind': $americanIndian = $race->getId(); break;
                case 'whi':
                case 'cau': $white = $race->getId(); break;
                case 'afr':
                case 'bla': $black = $race->getId(); break;
                case 'asi': $asian = $race->getId(); break;
                case 'nat': $nativeHawaiian = $race->getId(); break;
                case 'unk': $unknown = $race->getId(); break;
                case 'oth': $other = $race->getId(); break;
            }
        }

        $response = $this->render('AccardPDSBundle::plugin.js.twig', array(
            'gender_male' => isset($male) ? $male : 'null',
            'gender_female' => isset($female) ? $female : 'null',
            'gender_unknown' => isset($unknown) ? $unknown : 'null',
            'race_indian' => isset($americanIndian) ? $americanIndian : 'null',
            'race_white' => isset($white) ? $white : 'null',
            'race_black' => isset($black) ? $black : 'null',
            'race_asian' => isset($asian) ? $asian : 'null',
            'race_hawaiian' => isset($nativeHawaiian) ? $nativeHawaiian : 'null',
            'race_unknown' => isset($unknown) ? $unknown : 'null',
            'race_other' => isset($other) ? $other : 'null',
        ));
        $response->headers->set('Content-Type', 'application/javascript');

        return $response;
    }

    private function getOptionProvider()
    {
        return $this->get('accard.provider.option');
    }

    private function getPatients()
    {
        return $this->getDoctrine()->getManager('accard')->getRepository("AccardPDSBundle:Patient");
    }
}
