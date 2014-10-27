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
 * Frontend menu subscriber.
 *
 * Creates the default secondary menu structure for the frontend menus.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FrontendMenuSubscriber implements EventSubscriberInterface
{
    /**
     * Create secondary sidebar items.
     *
     * @param MenuBuilderEvent $event
     */
    public function createSidebarItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();
        $route = str_replace('accard_frontend_', '', $event->getRequest()->attributes->get('_route'));
        $baseRoute = explode('_', $route)[0];
        $settingsManager = $event->getSettingsManager();

        $repositories = $menu->getChild('repositories');
        $patient = $this->createSimpleItem($event, $repositories, 'patient', 'patient_index', 'patients');

        if ('patient' === $baseRoute) {
            $patient->setCurrent(true);
        }

        $diagnosisSettings = $settingsManager->load('diagnosis');
        if ($diagnosisSettings['enabled']) {
            $diagnosis = $this->createSimpleItem($event, $repositories, 'diagnosis', 'diagnosis_index', 'diagnoses');

            if ('diagnosis' === $baseRoute) {
                $diagnosis->setCurrent(true);
            }
        }

        $activitySettings = $settingsManager->load('activity');
        if ($activitySettings['enabled']) {
            $activity = $this->createSimpleItem($event, $repositories, 'activity', 'activity_index', 'activities');

            if ('activity' === $baseRoute || 'regimen' === $baseRoute) {
                $activity->setCurrent(true);
            }
        }

        $sampleSettings = $settingsManager->load('sample');
        if ($sampleSettings['enabled']) {
            $sample = $this->createSimpleItem($event, $repositories, 'sample', 'sample_index', 'samples');

            if ('sample' === $baseRoute) {
                $sample->setCurrent(true);
            }
        }

        $behaviorSettings = $settingsManager->load('behavior');
        if ($behaviorSettings['enabled']) {
            $behavior = $this->createSimpleItem($event, $repositories, 'behavior', 'behavior_index', 'behaviors');

            if ('behavior' === $baseRoute) {
                $behavior->setCurrent(true);
            }
        }

        $attributeSettings = $settingsManager->load('attribute');
        if ($attributeSettings['enabled']) {
            $attribute = $this->createSimpleItem($event, $repositories, 'attribute', 'attribute_index', 'attributes');

            if ('attribute' === $baseRoute) {
                $attribute->setCurrent(true);
            }
        }
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
        $route = 'accard_frontend_'.$route;
        $label = 'accard.menu.frontend.'.$label;

        return $menu->addChild($name, array('route' => $route))->setLabel($event->translate($label));
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            MenuEvents::FRONTEND_SIDEBAR => array('createSidebarItems', 999),
        );
    }
}
