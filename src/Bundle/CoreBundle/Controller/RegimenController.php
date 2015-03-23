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
use Accard\Bundle\RegimenBundle\Model\RegimenActivitiesChoice;
use Accard\Bundle\RegimenBundle\Form\Type\RegimenActivitiesChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Accard\Component\Diagnosis\Exception\DiagnosisNotFoundException;
use Accard\Component\Patient\Exception\PatientNotFoundException;
use Pagerfanta\Pagerfanta;

/**
 * Regimen controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function initialize(Request $request, SecurityContextInterface $securityContext)
    {
        $settings = $this->get('accard.settings.manager')->load('regimen');

        if ($securityContext->isGranted('ROLE_ADMIN')) {
            return;
        }

        if (!$settings['enabled']) {
            throw $this->createNotFoundException('Activities have been disabled. Please contact your administrator to turn them back on.');
        }
    }

    /**
     * Regimen activities action.
     *
     * @param Request $request
     * @param string $prototype
     * @param integer $id
     */
    public function activitiesAction(Request $request, $prototype, $id)
    {
        $resource = $this->findOr404($request);
        $formData = new RegimenActivitiesChoice($resource);
        $form = $this->createForm(new RegimenActivitiesChoiceType($resource), $formData);

        if (in_array($request->getMethod(), array('POST', 'PUT', 'PATCH')) &&
            $form->submit($request, !$request->isMethod('PATCH'))->isValid()) {
            $this->domainManager->update($resource);

            return $this->redirectHandler->redirectTo($resource);
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('activities.html'))
            ->setData(array(
                $this->config->getResourceName() => $resource,
                'form' => $form->createView()
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Design regimen action.
     *
     * @param Request $request
     */
    public function designAction(Request $request)
    {
        $manager = $this->get('accard.settings.manager');
        $settingsForm = $this->get('accard.settings.form_factory')->create('regimen');
        $settingsForm->setData($manager->load('regimen'));

        $criteria = $this->config->getCriteria();
        $sorting = $this->config->getSorting();


        // Paginator
        $repository = $this->getRepository();

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('design.html'))
            ->setData(array(
                'prototypes' => $this->getPrototypes(),
                'fields' => $this->getFields($request, $criteria, $sorting),
                'settings_form' => $settingsForm->createView(),
                'regimen_count' => $this->getRegimenCount(),
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Index regimens by prototype.
     *
     * @param Request $request
     *
     */
    public function indexByPrototypeAction(Request $request)
    {
        $provider = $this->get('accard.provider.regimen_prototype');
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
            $provider = $this->get('accard.provider.regimen_prototype');
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
        }

        if ($patient) {
            try {
                $patientProvider = $this->get('accard.provider.patient');
                $patient = $patientProvider->getPatient($patient);
                $resource->setPatient($patient);
            } catch (PatientNotFoundException $e) {
                throw $this->createNotFoundException('Patient could not be found.', $e);
            }
        }

        return $resource;
    }

    /**
     * Get regimen prototypes.
     *
     * @return array
     */
    private function getPrototypes()
    {
        return $this->get('accard.repository.regimen_prototype')->createPaginator();
    }

    /**
     * Get regimen fields.
     *
     * @return array
     */
    private function getFields($request, $criteria, $sorting)
    {
        $this->get('accard.repository.regimen_prototype_field')->findAll();
    }

    /**
     * Get the total number of regimens.
     *
     * @return integer
     */
    private function getRegimenCount()
    {
        return $this->get('accard.repository.regimen')->getCount();
    }
}
