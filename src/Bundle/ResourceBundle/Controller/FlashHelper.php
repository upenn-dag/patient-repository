<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Accard\Bundle\ResourceBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Flashes helper.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FlashHelper
{
    /**
     * @var Configuration
     */
    private $config;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(Configuration $config, TranslatorInterface $translator, SessionInterface $session)
    {
        $this->config = $config;
        $this->translator = $translator;
        $this->session = $session;
    }

    /**
     * @param string $type
     * @param string $eventName
     * @param array  $params
     *
     * @return mixed
     */
    public function setFlash($type, $eventName, $params = array())
    {
        /** @var FlashBag $flashBag */
        $flashBag = $this->session->getBag('flashes');
        $flashBag->add($type, $this->generateFlashMessage($eventName, $params));
    }

    /**
     * @param string $eventName
     * @param array  $params
     *
     * @return string
     */
    private function generateFlashMessage($eventName, $params = array())
    {
        if (false === strpos($eventName, 'accard.')) {
            $message = $this->config->getFlashMessage($eventName);
            $translatedMessage = $this->translateFlashMessage($message, $params);

            if ($message !== $translatedMessage) {
                return $translatedMessage;
            }

            return $this->translateFlashMessage('accard.resource.'.$eventName, $params);
        }

        return $this->translateFlashMessage($eventName, $params);
    }

    /**
     * @param string $message
     * @param array  $params
     *
     * @return string
     */
    private function translateFlashMessage($message, $params = array())
    {
        $resource = ucfirst(str_replace('_', ' ', $this->config->getResourceName()));
        $resourceLower = strtolower($resource);
        $baseParams = array('%resource%' => $resource, '%resource_lower%' => $resourceLower);

        return $this->translator->trans($message, array_merge($baseParams, $params), 'flashes');
    }
}
