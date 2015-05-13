<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Accard\Bundle\ResourceBundle\EventListener;

use Accard\Bundle\ResourceBundle\Controller\ResourceController;
use Accard\Bundle\ResourceBundle\Controller\InitializableController;
use Accard\Bundle\ResourceBundle\ExpressionLanguage\AccardLanguage;
use Accard\Bundle\ResourceBundle\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Doctrine listener used to set the request on the configurable controllers.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class KernelControllerSubscriber implements EventSubscriberInterface
{
    /**
     * Security context.
     *
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * Expression language.
     *
     * @var ExpressionLanguage
     */
    private $exprLanguage;


    /**
     * Constructor.
     *
     * @param AuthorizationCheckerInterface $authChecker
     * @param ExpressionLanguage $exprLanguage
     */
    public function __construct(AuthorizationCheckerInterface $authChecker,
                                ExpressionLanguage $exprLanguage)
    {
        $this->authChecker = $authChecker;
        $this->exprLanguage = $exprLanguage;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'kernel.controller' => array('onKernelController', 0)
        );
    }

    /**
     * Before controller action listener.
     *
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ExpressionAwareController) {
            // Initialize Accard Language component.
            AccardLanguage::setExpressionLanguage($this->exprLanguage);
        }

        // Inject the request if required.
        if ($controller[0] instanceof ResourceController) {
            $controller[0]->getConfiguration()->setRequest($event->getRequest());
        }

        // Run initialization if required.
        if ($controller[0] instanceof InitializableController) {
            $controller[0]->initialize($event->getRequest(), $this->authChecker);
        }
    }
}
