<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Accard\Bundle\WebBundle\Event\MenuBuilderEvent;
use DAG\Bundle\SettingsBundle\Manager\SettingsManager;

/**
 * Abstract menu builder.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class AbstractMenuBuilder
{
    /**
     * Menu factory.
     *
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * Security context.
     *
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * Translator instance.
     *
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Event dispatcher.
     *
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Settings manager.
     *
     * @var SettingsManager
     */
    protected $settingsManager;


    /**
     * Constructor.
     *
     * @param FactoryInterface $factory
     * @param SecurityContextInterface $securityContext
     * @param TranslatorInterface $translator
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(FactoryInterface $factory,
                                SecurityContextInterface $securityContext,
                                TranslatorInterface $translator,
                                EventDispatcherInterface $eventDispatcher,
                                SettingsManager $settingsManager)
    {
        $this->factory = $factory;
        $this->securityContext = $securityContext;
        $this->translator = $translator;
        $this->eventDispatcher = $eventDispatcher;
        $this->settingsManager = $settingsManager;
    }

    /**
     * Translate label.
     *
     * @param string $label
     * @param array  $parameters
     *
     * @return string
     */
    protected function translate($label, $parameters = array())
    {
        return $this->translator->trans($label, $parameters);
    }

    /**
     * Create a new menu event.
     *
     * @param ItemInterface $item
     * @return MenuBuilderEvent
     */
    protected function createMenuEvent(ItemInterface $item, Request $request)
    {
        return new MenuBuilderEvent($this->factory,
                                    $item,
                                    $request,
                                    $this->translator,
                                    $this->securityContext,
                                    $this->settingsManager);
    }
}
