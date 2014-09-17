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
 * Attribute controller.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AttributeController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function initialize(Request $request, SecurityContextInterface $securityContext)
    {
        $settings = $this->get('accard.settings.manager')->load('attribute');
        if ($securityContext->isGranted('ROLE_ADMIN')) {
            return;
        }

        if (!$settings['enabled']) {
            throw $this->createNotFoundException('Attributes have been disabled. Please contact your administrator to turn them back on.');
        }
    }

    /**
     * Design attribute action.
     *
     * @param Request $request
     * @todo create logical actions
     */
    public function designAction(Request $request)
    {
        $manager = $this->get('accard.settings.manager');
        $settingsForm = $this->get('accard.settings.form_factory')->create('attribute');
        $settingsForm->setData($manager->load('attribute'));

        $view = $this->view()
            ->setTemplate($this->config->getTemplate('design.html'))
            ->setData(array(
                'settings_form' => $settingsForm->createView(),
                'attribute_count' => $this->getAttributeCount(),
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Get the total number of attributes.
     *
     * @return integer
     */
    private function getAttributeCount()
    {
        return $this->get('accard.repository.attribute')->getCount();
    }
}
