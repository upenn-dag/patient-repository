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
use Symfony\Component\HttpFoundation\JsonResponse;
use Accard\Component\Option\Model\OptionInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Accard\Bundle\ResourceBundle\ExpressionLanguage\AccardLanguage;

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
        $patientRepository = $this->get('accard.repository.patient');
        $patients = $patientRepository->findAll();


        $genderCount = array();
        
        foreach($patients as $patient) {
            if(! array_key_exists($patient->getGender()->getValue(), $genderCount) ) {
                $genderCount[$patient->getGender()->getValue()] = 1;
            } else {
                $genderCount[$patient->getGender()->getValue()] = $genderCount[$patient->getGender()->getValue()] + 1;
            }
        }

        $raceCount = array();

        foreach($patients as $patient) {
            if(! array_key_exists($patient->getRace()->getValue(), $raceCount) ) {
                $raceCount[$patient->getRace()->getValue()] = 1;
            } else {
                $raceCount[$patient->getRace()->getValue()] = $raceCount[$patient->getRace()->getValue()] + 1;
            }
        }

        $diagnosisRepository = $this->get('accard.repository.diagnosis');
        $diagnoses = $diagnosisRepository->findall();

        $dxCodeCount = array();
        foreach($diagnoses as $diagnosis) {
            if(! array_key_exists($diagnosis->getCode()->getCode(), $dxCodeCount) ) {
                $dxCodeCount[$diagnosis->getCode()->getCode()] = 1;
            } else {
                $dxCodeCount[$diagnosis->getCode()->getCode()] = $dxCodeCount[$diagnosis->getCode()->getCode()] + 1;
            }
        }

        $dxAges = array();
        foreach($diagnoses as $diagnosis) {
            $diagnosisDate = $diagnosis->getStartDate();
            $patient = $diagnosis->getPatient();
            $dob = $patient->getDateOfBirth();

            $ageAtDx = $diagnosisDate->diff($dob);

            $dxAges[] = $ageAtDx->y;
        }

        $dxAgeMean = array_sum($dxAges) / count($dxAges);


        $dxPhaseCount = array();
        foreach($diagnoses as $diagnosis) {
            foreach($diagnosis->getPhases()->getValues() as $phase) {
                if(! array_key_exists($phase->getPhase()->getPresentation(), $dxPhaseCount)) {
                    $dxPhaseCount[$phase->getPhase()->getPresentation()] = 1;
                } else {
                    $dxPhaseCount[$phase->getPhase()->getPresentation()] + 1;
                }
            }
        }

        $patientPhaseCount = array();
        foreach($patients as $patient) {
            foreach($patient->getPhases()->getValues() as $phase) {
                if(! array_key_exists($phase->getPhase()->getPresentation(), $patientPhaseCount)) {
                    $patientPhaseCount[$phase->getPhase()->getPresentation()] = 1;
                } else {
                    $patientPhaseCount[$phase->getPhase()->getPresentation()] + 1;
                }
            }
        }

        return $this->render('Theme:Frontend:main.html.twig', array(
                'patients'          => $patients,
                'raceCount'         => $raceCount,
                'genderCount'       => $genderCount,
                'dxCodeCount'       => $dxCodeCount,
                'dxAgeMean'         => $dxAgeMean,
                'dxAges'            => $dxAges,
                'dxPhaseCount'      => $dxPhaseCount,
                'patientPhaseCount' => $patientPhaseCount,
        ));
    }

    /**
     * Get the Accard State object.
     *
     * @return JsonResponse
     */
    public function stateAction(Request $request)
    {
        $theState = $this->get('accard.state')->getState();

        return new JsonResponse($theState);
    }

    /**
     * Get the description for a given resource and id.
     *
     * @param Request $request
     * @param string $type
     * @param integer $id
     * @return JsonResponse
     */
    public function lastCreatedAction(Request $request)
    {
        // This needs to be done because we are accessing the expression
        // language outside of the resource controller.
        AccardLanguage::setExpressionLanguage($this->get('accard.expression_language'));

        $session = $this->get('session');
        $response = new JsonResponse();
        $lastResourceType = $session->get('accard-last-created-resource-type');
        $lastResourceId = $session->get('accard-last-created-resource-id');

        if (!$lastResourceId || !$lastResourceType) {
            $response->setData(array());
            $response->setStatusCode(400);
        } else {
            $serializer = $this->get('jms_serializer');
            $repository = $this->get(sprintf('accard.repository.%s', $lastResourceType));
            $resource = $repository->find($lastResourceId);
            $response->setContent($serializer->serialize($resource, 'json'));
        }

        return $response;
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

    /**
     * List logs for user.
     *
     * @param Request $request
     */
    public function userLogAction(Request $request)
    {
        $repository = $this->get('accard.manager.log')->getRepository($this->container->getParameter('accard.model.log.class'));
        $queryBuilder = $repository->getUserLogBuilder($this->getUser());
        $logs = new Pagerfanta(new DoctrineORMAdapter($queryBuilder));

        $logs->setMaxPerPage(15);
        $logs->setCurrentPage($request->get('page', 1));

        return $this->render('AccardWebBundle:Frontend:userLog.html.twig', array(
            'logs' => $logs,
        ));
    }

    /**
     * Create a prototype choice form.
     *
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function prototypeChoiceFormAction(Request $request, $type)
    {
        $form = $this->createPrototypeChoiceForm($type);

        return $this->render('AccardWebBundle:Common/Form:prototypeChoiceForm.html.twig', array(
            'form' => $form->createView(),
            'type' => $type,
        ));
    }

    /**
     * Redirect to proper place from prototype selection.
     *
     * @param Request $request
     * @param string $type
     * @return RedirectResponse
     */
    public function prototypeRedirectAction(Request $request, $type)
    {
        $form = $this->createPrototypeChoiceForm($type);
        $form->handleRequest($request);
        $prototype = $form->get('prototype')->getData();

        if ($form->get('create')->isClicked()) {
            $route = sprintf('accard_frontend_%s_create', $type);
            $url = $this->generateUrl($route, array('prototype' => $prototype->getName()));
        } elseif ($form->get('index')->isClicked()) {
            $route = sprintf('accard_frontend_%s_index_by_prototype', $type);
            $url = $this->generateUrl($route, array('prototype' => $prototype->getName()));
        }

        if (isset($url)) {
            return $this->redirect($url);
        }

        throw $this->createNotFoundException();
    }

    /**
     * Create prototype choice form.
     *
     * @param string $type
     */
    private function createPrototypeChoiceForm($type)
    {
        $prototypeChoiceType = sprintf('accard_%s_prototype_choice', $type);
        $builder = $this->get('form.factory')->createNamedBuilder(null, 'form', array(), array(
            'csrf_protection' => false,
            'method' => 'GET',
        ));

        $builder->add('prototype', $prototypeChoiceType, array(
            'required' => true,
            'placeholder' => 'accard.prototype_choice.action.choose',
        ));

        $builder->add('create', 'submit', array(
            'label' => 'accard.prototype_choice.action.create',
        ));

        $builder->add('index', 'submit', array(
            'label' => 'accard.prototype_choice.action.index',
        ));

        return $builder->getForm();
    }

    /**
     * Present option 'quick add' form.
     *
     * @param Request $request
     * @param integer $option
     */
    public function quickAddOptionAction(Request $request, $option)
    {
        $optionProvider = $this->get('accard.provider.option');

        if (!$optionProvider->hasOption($option)) {
            throw $this->createNotFoundException();
        }

        $option = $optionProvider->getOption($option);
        $form = $this->createQuickAddForm($option);

        if ($request->isMethod('POST')) {
            $response = new JsonResponse(array());
            $form->handleRequest($request);
            $optionValue = $form->getData()['newValue'];

            if ($form->isValid()) {
                $em = $this->get('accard.manager.option');
                $option->addValue($optionValue);
                $em->persist($option);
                $em->persist($optionValue);
                $em->flush();
            } else {
                $response->setStatusCode(400);
            }

            return $response;
        }

        return $this->render('AccardWebBundle:Frontend\Option:create.html.twig', array(
            'form' => $form->createView(),
            'option' => $option,
        ));
    }

    /**
     * Create a form for the quick add.
     *
     * @param OptionInterface $option
     */
    private function createQuickAddForm(OptionInterface $option)
    {
        $builder = $this->createFormBuilder(array(), array(
            'action' => $this->generateUrl('accard_frontend_option_quickadd', array('option' => $option->getId())),
            'method' => 'POST',
        ));

        $builder->add('newValue', 'accard_option_value', array(
            'required' => true,
        ));

        return $builder->getForm();
    }

}
