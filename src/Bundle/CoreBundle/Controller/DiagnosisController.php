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

use Accard\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Pagerfanta\Pagerfanta;
use Accard\Component\Patient\Exception\PatientNotFoundException;

/**
 * Diagnosis controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DiagnosisController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function initialize(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $settings = $this->get('accard.settings.manager')->load('diagnosis');

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return;
        }

        if (!$settings['enabled']) {
            throw $this->createNotFoundException('Diagnoses have been disabled. Please contact your administrator to turn them back on.');
        }
    }

    /**
     * Design diagnosis action.
     *
     * @param Request $request
     * @todo create logical actions
     */
    public function designAction(Request $request)
    {
        $manager = $this->get('accard.settings.manager');
        $settingsForm = $this->get('accard.settings.form_factory')->create('diagnosis');
        $settingsForm->setData($manager->load('diagnosis'));

        $view = $this->view()
            ->setTemplate($this->config->getTemplate('design.html'))
            ->setData(array(
                'fields' => $this->getFields(),
                'settings_form' => $settingsForm->createView(),
                'diagnoses_count' => $this->getDiagnosesCount(),
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Index diagnoses by patient.
     *
     * @param Request $request
     *
     */
    public function indexByPatientAction(Request $request)
    {
        $repository = $this->get('accard.repository.patient');
        $patientId = $request->get('patient');

        if (!$patientId || !$patient = $repository->find($request->get('patient'))) {
            throw $this->createNotFoundException(sprintf('The patient with id="%s" does not exist.', $patientId));
        }

        $parameters = $this->config->getParameters();
        $parameters['criteria']['patient'] = $patient->getId();
        $this->config->setParameters($parameters);

        return $this->indexAction($request);
    }

    /**
     * Code group action.
     *
     * @param Request $request
     */
    public function codeGroupAction(Request $request)
    {
        $view = $this->view()
            ->setTemplate($this->config->getTemplate('groupIndex.html'))
            ->setData(array(
                'diagnosis_code_groups' => $this->getCodeGroups(),
                'diagnosis_codes' => $this->getCodes(),
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        $resource = parent::createNew();

        if (!$request = $this->config->getRequest()) {
            return $resource;
        }

        $patient = $request->get('patient');

        if ($patient) {
            try {
                $patientProvier = $this->get('accard.provider.patient');
                $patient = $patientProvier->getPatient($patient);
                $resource->setPatient($patient);
            } catch (PatientNotFoundException $e) {
                throw $this->createNotFoundException('Patient could not be found.', $e);
            }
        }

        return $resource;
    }

    /**
     * Get paginated list of all fields.
     *
     * @return Pagerfanta
     */
    private function getFields()
    {
        return $this->get('accard.repository.diagnosis_field')->findAll();
    }

    /**
     * Get all code groups.
     *
     * @return array
     */
    private function getCodeGroups()
    {
        return $this->get('accard.repository.diagnosis_code_group')->findAll();
    }

    /**
     * Get all codes.
     *
     * @return array
     */
    private function getCodes()
    {
        return $this->get('accard.repository.diagnosis_code')->findAll();
    }

    /**
     * Get the total number of diagnoses.
     *
     * @return integer
     */
    private function getDiagnosesCount()
    {
        return $this->get('accard.repository.diagnosis')->getCount();
    }
}
