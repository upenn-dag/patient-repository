<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SettingsBundle\Controller;

use Accard\Bundle\SettingsBundle\Form\Factory\SettingsFormFactoryInterface;
use Accard\Bundle\SettingsBundle\Manager\SettingsManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Settings controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SettingsController extends Controller
{
    /**
     * Edit configuration with given namespace.
     *
     * @param Request $request
     * @param string  $namespace
     * @return Response
     */
    public function updateAction(Request $request, $namespace)
    {
        $manager = $this->getSettingsManager();
        $settings = $manager->load($namespace);

        $form = $this
            ->getSettingsFormFactory()
            ->create($namespace)
        ;

        $form->setData($settings);

        if ($form->handleRequest($request)->isValid()) {
            $messageType = 'success';
            try {
                $manager->save($namespace, $form->getData());
                $message = $this->getTranslator()->trans('accard.settings.update', array(), 'flashes');
            } catch (ValidatorException $exception) {
                $message = $this->getTranslator()->trans($exception->getMessage(), array(), 'validators');
                $messageType = 'error';
            }
            $request->getSession()->getBag('flashes')->add($messageType, $message);

            if ($request->headers->has('referer')) {
                return $this->redirect($request->headers->get('referer'));
            }
        }

        return $this->render($request->attributes->get('template', 'AccardSettingsBundle:Settings:update.html.twig'), array(
            'settings' => $settings,
            'form'     => $form->createView()
        ));
    }

    /**
     * Get settings manager.
     *
     * @return SettingsManagerInterface
     */
    protected function getSettingsManager()
    {
        return $this->get('accard.settings.manager');
    }

    /**
     * Get settings form factory.
     *
     * @return SettingsFormFactoryInterface
     */
    protected function getSettingsFormFactory()
    {
        return $this->get('accard.settings.form_factory');
    }

    /**
     * Get translator.
     *
     * @return TranslatorInterface
     */
    protected function getTranslator()
    {
        return $this->get('translator');
    }
}
