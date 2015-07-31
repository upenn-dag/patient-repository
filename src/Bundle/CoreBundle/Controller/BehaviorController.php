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
 * Behavior controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BehaviorController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function initialize(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $settings = $this->get('dag.settings.manager')->load('behavior');

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return;
        }

        if (!$settings['enabled']) {
            throw $this->createNotFoundException('Activities have been disabled. Please contact your administrator to turn them back on.');
        }
    }

    /**
     * Design behavior action.
     *
     * @param Request $request
     */
    public function designAction(Request $request)
    {
        $manager = $this->get('dag.settings.manager');
        $settingsForm = $this->get('dag.settings.form_factory')->create('behavior');
        $settingsForm->setData($manager->load('behavior'));

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('design.html'))
            ->setData(array(
                'prototypes' => $this->getPrototypes(),
                'fields' => $this->getFields(),
                'settings_form' => $settingsForm->createView(),
                'behavior_count' => $this->getBehaviorCount(),
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Index behaviors by prototype.
     *
     * @param Request $request
     *
     */
    public function indexByPrototypeAction(Request $request)
    {
        $provider = $this->get('accard.provider.behavior_prototype');
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
            $provider = $this->get('accard.provider.behavior_prototype');
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
     * Get behavior prototypes.
     *
     * @return array
     */
    private function getPrototypes()
    {
        return $this->get('accard.repository.behavior_prototype')->createPaginator();
    }

    /**
     * Get behavior fields.
     *
     * @return array
     */
    private function getFields()
    {
        return $this->Get('accard.repository.behavior_prototype_field')->findAll();
    }

    /**
     * Get the total number of behaviors.
     *
     * @return integer
     */
    private function getBehaviorCount()
    {
        return $this->get('accard.repository.behavior')->getCount();
    }
}
