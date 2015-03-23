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
use Symfony\Component\Security\Core\SecurityContextInterface;
use Pagerfanta\Pagerfanta;

/**
 * Activity controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function initialize(Request $request, SecurityContextInterface $securityContext)
    {
        $settings = $this->get('accard.settings.manager')->load('activity');

        if ($securityContext->isGranted('ROLE_ADMIN')) {
            return;
        }

        if (!$settings['enabled']) {
            throw $this->createNotFoundException('Activities have been disabled. Please contact your administrator to turn them back on.');
        }
    }

    /**
     * Design activity action.
     *
     * @param Request $request
     */
    public function designAction(Request $request)
    {
        $manager = $this->get('accard.settings.manager');
        $settingsForm = $this->get('accard.settings.form_factory')->create('activity');
        $settingsForm->setData($manager->load('activity'));

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('design.html'))
            ->setData(array(
                'prototypes' => $this->getPrototypes(),
                'fields' => $this->getFields(),
                'settings_form' => $settingsForm->createView(),
                'activity_count' => $this->getActivityCount(),
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Index activities by prototype.
     *
     * @param Request $request
     *
     */
    public function indexByPrototypeAction(Request $request)
    {
        $provider = $this->get('accard.provider.activity_prototype');
        $prototypeName = $request->get('prototype', 'default');

        try {
            $prototype = $provider->getPrototypeByName($prototypeName);
        } catch (\Exception $e) {
            throw $this->createNotFoundException(sprintf('The prototype "%s" does not exist.', $prototypeName));
        }

        $parameters = $this->config->getParameters();
        $parameters['criteria']['prototype'] = $prototype->getId();
        $this->config->setParameters($parameters);

        return $this->indexAction($request);
    }

    /**
     * {@inheritdoc}
     */
    public function getForm($resource = null)
    {
        if ($resource && null === $resource->getPrototype()) {
            $request = $this->config->getRequest();
            $provider = $this->get('accard.provider.activity_prototype');
            $prototypeName = $request->get('prototype', 'default');

            try {
                $prototype = $provider->getPrototypeByName($prototypeName);
                $resource->setPrototype($prototype);
            } catch (\Exception $e) {
                throw $this->createNotFoundException(sprintf('The prototype "%s" does not exist.', $prototypeName));
            }
        }

        return parent::getForm($resource);
    }

    /**
     * @inheritdoc
     */
    public function createNew()
    {
        $resource = parent::createNew();

        if (!$request = $this->config->getRequest()) {
            return $resource;
        }

        $patient = $request->get('patient');
        $diagnosis = $request->get('diagnosis');

        if ($diagnosis) {
            try {
                $diagnosisProvider = $this->get('accard.provider.diagnosis');
                $diagnosis = $diagnosisProvider->getDiagnosis($diagnosis);
                $resource->setDiagnosis($diagnosis);
                $resource->setPatient($diagnosis->getPatient());
            } catch (DiagnosisNotFoundException $e) {
                throw $this->createNotFoundException('Diagnosis could not be found.', $e);
            }
        } else {
            if ($patient) {
                try {
                    $patientProvider = $this->get('accard.provider.patient');
                    $patient = $patientProvider->getPatient($patient);
                    $resource->setPatient($patient);
                } catch (PatientNotFoundException $e) {
                    throw $this->createNotFoundException('Patient could not be found.', $e);
                }
            }
        }

        return $resource;
    }

    /**
     * Get activity prototypes.
     *
     * @return array
     */
    private function getPrototypes()
    {
        return $this->get('accard.provider.activity_prototype')->getPrototypes();
    }

    /**
     * Get activity fields.
     *
     * @return array
     */
    private function getFields()
    {
        return $this->get('accard.repository.activity_prototype_field')->findAll();
    }

    /**
     * Get the total number of activities.
     *
     * @return integer
     */
    private function getActivityCount()
    {
        return $this->get('accard.repository.activity')->getCount();
    }
}
