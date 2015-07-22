<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use DAG\Bundle\SettingsBundle\Manager\SettingsManager;

/**
 * Menu builder event.
 *
 * Fired when building menus on both the front end and backend. This provides
 * the ability to programatically alter the menu structure.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class MenuBuilderEvent extends Event
{
    /**
     * Menu factory.
     *
     * @var FactoryInterface
     */
    private $factory;

    /**
     * Menu.
     *
     * @var ItemInterface
     */
    private $menu;

    /**
     * Request.
     *
     * @var Request
     */
    private $request;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Security context.
     *
     * @var SecurityContextInterface
     */
    private $securityContext;

    /**
     * Settings manager.
     *
     * @var SettingsManager
     */
    private $settingsManager;


    /**
     * Constructor.
     *
     * @param FactoryInterface $factory
     * @param ItemInterface $menu
     */
    public function __construct(FactoryInterface $factory,
                                ItemInterface $menu,
                                Request $request,
                                TranslatorInterface $translator,
                                SecurityContextInterface $securityContext,
                                SettingsManager $settingsManager)
    {
        $this->factory = $factory;
        $this->menu = $menu;
        $this->request = $request;
        $this->translator = $translator;
        $this->securityContext = $securityContext;
        $this->settingsManager = $settingsManager;
    }

    /**
     * Get menu factory.
     *
     * @return FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Get menu.
     *
     * @return ItemInterface
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Get request.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get translator.
     *
     * @return TranslatorInterface
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * Get security context.
     *
     * @return SecurityContextInterface
     */
    public function getSecurityContext()
    {
        return $this->securityContext;
    }

    /**
     * Get settings manager.
     *
     * @return SettingsManager
     */
    public function getSettingsManager()
    {
        return $this->settingsManager;
    }

    /**
     * Translate string.
     *
     * @param string $label
     * @param array  $parameters
     *
     * @return string
     */
    public function translate($label, $parameters = array())
    {
        return $this->translator->trans($label, $parameters);
    }

    /**
     * Create and attach a simple menu item.
     *
     * This is purely for convenience.
     *
     * @param string $name
     * @param string $route
     * @param string $label
     * @return ItemInterface
     */
    public function createSimpleItem($name, $route, $label)
    {
        return $this
            ->menu
            ->addChild($name, array('route' => $route))
            ->setLabel($this->translate($label));
    }
}
