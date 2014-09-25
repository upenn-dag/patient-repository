<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\EventListener;

use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Accard\Bundle\WebBundle\MenuEvents;
use Accard\Bundle\WebBundle\Event\MenuBuilderEvent;

/**
 * Backend menu subscriber.
 *
 * Creates the default secondary menu structure for the backend menus.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class BackendMenuSubscriber implements EventSubscriberInterface
{
    /**
     * Create secondary sidebar items.
     *
     * @param MenuBuilderEvent $event
     */
    public function createSidebarItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();
        $uri = $event->getRequest()->getUri();

        $design = $menu->getChild('design');

        $patient = $this->createSimpleItem($event, $design, 'patient', 'patient_design', 'patient');

        if (false !== strpos($uri, '/patient/')) {
            $patient->setCurrent(true);
        }

        $diagnosis = $this->createSimpleItem($event, $design, 'diagnosis', 'diagnosis_design', 'diagnosis');

        if (false !== strpos($uri, '/diagnosis/') || false !== strpos($uri, 'diagnosis/code')) {
            $diagnosis->setCurrent(true);
        }

        $activity = $this->createSimpleItem($event, $design, 'activity', 'activity_design', 'activity');

        if (false !== strpos($uri, '/activity/')) {
            $activity->setCurrent(true);
        }

        $behavior = $this->createSimpleItem($event, $design, 'behavior', 'behavior_design', 'behavior');
        $attribute = $this->createSimpleItem($event, $design, 'attribute', 'attribute_design', 'attribute');

        $settings = $menu->getChild('settings');
        $this->createSimpleItem($event, $settings, 'general', "general_settings", 'general_settings');
        $this->createSimpleItem($event, $settings, 'theme', "theme_settings", 'theme_settings');
    }

    /**
     * Create simple menu item.
     *
     * @param MenuBuilderEvent $event
     * @param ItemInterface $menu
     * @param string $name
     * @param string $route
     * @param string $label
     * @return ItemInterface
     */
    private function createSimpleItem(MenuBuilderEvent $event, ItemInterface $menu, $name, $route, $label)
    {
        $route = 'accard_backend_'.$route;
        $label = 'accard.menu.backend.'.$label;

        return $menu->addChild($name, array('route' => $route))->setLabel($event->translate($label));
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            MenuEvents::BACKEND_SIDEBAR => array('createSidebarItems', 999),
        );
    }
}
