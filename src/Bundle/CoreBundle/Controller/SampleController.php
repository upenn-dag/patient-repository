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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Pagerfanta\Pagerfanta;
use Accard\Component\Patient\Exception\PatientNotFoundException;

/**
 * Sample controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SampleController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function initialize(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $settings = $this->get('accard.settings.manager')->load('sample');

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return;
        }

        if (!$settings['enabled']) {
            throw $this->createNotFoundException('Activities have been disabled. Please contact your administrator to turn them back on.');
        }
    }

    /**
     * Design sample action.
     *
     * @param Request $request
     */
    public function designAction(Request $request)
    {
        $manager = $this->get('accard.settings.manager');
        $settingsForm = $this->get('accard.settings.form_factory')->create('sample');
        $settingsForm->setData($manager->load('sample'));

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('design.html'))
            ->setData(array(
                'prototypes' => $this->getPrototypes(),
                'fields' => $this->getFields($request),
                'settings_form' => $settingsForm->createView(),
                'sample_count' => $this->getSampleCount(),
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Index samples by prototype.
     *
     * @param Request $request
     *
     */
    public function indexByPrototypeAction(Request $request)
    {
        $provider = $this->get('accard.provider.sample_prototype');
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
            $provider = $this->get('accard.provider.sample_prototype');
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
     * Get sample prototypes.
     *
     * @return array
     */
    private function getPrototypes()
    {
        return $this->get('accard.repository.sample_prototype')->createPaginator();
    }

    /**
     * Get sample fields.
     *
     * @return array
     */
    private function getFields($request)
    {
        return $this->get('accard.repository.sample_prototype_field')->findAll();
    }

    /**
     * Get the total number of samples.
     *
     * @return integer
     */
    private function getSampleCount()
    {
        return $this->get('accard.repository.sample')->getCount();
    }
}
