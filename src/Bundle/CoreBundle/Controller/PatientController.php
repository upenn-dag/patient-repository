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
use Accard\Bundle\SettingsBundle\Model\Settings;
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
        $manager = $this->get('accard.settings.manager');
        $settingsForm = $this->get('accard.settings.form_factory')->create('patient');
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
     * Import patient index.
     *
     * @param Request $request
     */
    public function importAction(Request $request)
    {
        $enabled = $this->getPatientSettings()->get('import_enabled');

        if (!$enabled) {
            throw $this->createAccessDeniedException(
                $this->get('translator')->trans('accard.form.patient.import_disabled')
            );
        }

        $criteria = $this->config->getCriteria();
        $sorting = $this->config->getSorting();

        $repository = $this->get('accard.repository.import_patient');

        $resources = $this->resourceResolver->getResource(
            $repository,
            'createActivePaginator',
            array($criteria, $sorting)
        );
        $resources->setCurrentPage($request->get('page', 1), true, true);
        $resources->setMaxPerPage($this->config->getPaginationMaxPerPage());

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('import.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData($resources)
        ;

        return $this->handleView($view);
    }

    /**
     * Get patient settings.
     *
     * @return Settings
     */
    private function getPatientSettings()
    {
        return $this->get('accard.settings.manager')->load('patient');
    }

    /**
     * Get paginated list of all fields.
     *
     * @return Pagerfanta
     */
    private function getFields()
    {
        return $this->get('accard.repository.patient_field')->createPaginator();
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
