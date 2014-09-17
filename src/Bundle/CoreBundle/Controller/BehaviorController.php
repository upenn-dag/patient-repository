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
 * Behavior controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class BehaviorController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function initialize(Request $request, SecurityContextInterface $securityContext)
    {
        $settings = $this->get('accard.settings.manager')->load('behavior');

        if ($securityContext->isGranted('ROLE_ADMIN')) {
            return;
        }

        if (!$settings['enabled']) {
            throw $this->createNotFoundException('Behaviors have been disabled. Please contact your administrator to turn them back on.');
        }

        if ($this->routeMatches($request, 'behavior_alcohol') && !$settings['enable_alcohol']) {
            throw $this->createNotFoundException('Alcohol behavior has been disabled. Please contact your administrator to turn it on.');
        }

        if ($this->routeMatches($request, 'behavior_smoking') && !$settings['enable_smoking']) {
            throw $this->createNotFoundException('Smoking behavior has been disabled. Please contact your administrator to turn it on.');
        }

        if ($this->routeMatches($request, 'behavior_illicit_drug') && !$settings['enable_illicit_drugs']) {
            throw $this->createNotFoundException('Illicit drug behavior has been disabled. Please contact your administrator to turn it on.');
        }

        if ($this->routeMatches($request, 'behavior_occupation') && !$settings['enable_occupation']) {
            throw $this->createNotFoundException('Occupation behavior has been disabled. Please contact your administrator to turn it on.');
        }

        if ($this->routeMatches($request, 'behavior_education') && !$settings['enable_education']) {
            throw $this->createNotFoundException('Education behavior has been disabled. Please contact your administrator to turn it on.');
        }
    }

    /**
     * Test if current route matches a given string.
     *
     * @param Request $request
     * @param string $searchString
     * @return boolean
     */
    private function routeMatches(Request $request, $searchString)
    {
        return false !== strpos($request->get('_route'), $searchString);
    }

    /**
     * Design behavior action.
     *
     * @param Request $request
     * @todo create logical actions
     */
    public function designAction(Request $request)
    {
        $manager = $this->get('accard.settings.manager');
        $settingsForm = $this->get('accard.settings.form_factory')->create('behavior');
        $settingsForm->setData($manager->load('behavior'));

        $view = $this->view()
            ->setTemplate($this->config->getTemplate('design.html'))
            ->setData(array(
                'settings_form' => $settingsForm->createView(),
                'behavior_count' => $this->getBehaviorCount(),
            ))
        ;

        return $this->handleView($view);
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
