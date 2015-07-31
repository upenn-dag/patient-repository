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

use DAG\Bundle\ResourceBundle\Controller\ResourceController;
use DAG\Bundle\SettingsBundle\Model\Settings;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;

/**
 * Patient controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientController extends ResourceController
{
    /**
     * Design patient action.
     *
     * @param Request $request
     */
    public function designAction(Request $request)
    {
        $manager = $this->get('dag.settings.manager');
        $settingsForm = $this->get('dag.settings.form_factory')->create('patient');
        $settingsForm->setData($manager->load('patient'));

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('design.html'))
            ->setData(array(
                'fields' => $this->getFields(),
                'settings_form' => $settingsForm->createView(),
                'patient_count' => $this->getPatientCount(),
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Render patient filter form.
     *
     * @return Response
     */
    public function filterAction()
    {
        $request = $this->get('request_stack')->getMasterRequest();
        $criteria = $request->query->get('criteria', array());

        return $this->render('AccardWebBundle:Frontend/Patient:filterForm.html.twig', array(
            'form' => $this->getPatientFilterForm($criteria)->createView(),
            'filter_criteria' => $criteria,
        ));
    }

    /**
     * Get patient settings.
     *
     * @return Settings
     */
    private function getPatientSettings()
    {
        return $this->get('dag.settings.manager')->load('patient');
    }

    /**
     * Get patient phases.
     *
     * @return ArrayCollection|PatientPhaseInterface[]
     */
    private function getPatientPhases()
    {
        return $this->get('accard.provider.patient_phase')->getPhases();
    }

    /**
     * Get patient phase provider.
     *
     * @return PhaseProviderInterface
     */
    private function getPatientPhaseProvider()
    {
        return $this->get('accard.provider.patient_phase');
    }

    /**
     * Get patient filter form.
     *
     * @param array $criteria
     * @return FormInterface
     */
    private function getPatientFilterForm(array $criteria = array())
    {
        return $this
            ->get('form.factory')
            ->createNamed('criteria', 'accard_patient_filter', $criteria, array('csrf_protection' => false));
    }

    /**
     * Get paginated list of all fields.
     *
     * @return Pagerfanta
     */
    private function getFields()
    {
        return $this->get('accard.repository.patient_field')->findAll();
    }

    /**
     * Get the total number of patients.
     *
     * @return integer
     */
    private function getPatientCount()
    {
        return $this->get('accard.repository.patient')->getCount();
    }
}
