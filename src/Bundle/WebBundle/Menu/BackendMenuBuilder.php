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

use Knp\Menu\ItemInterface;
use Accard\Bundle\WebBundle\MenuEvents;
use Accard\Bundle\WebBundle\Event\MenuBuilderEvent;
use Symfony\Component\HttpFoundation\Request;

/**
 * Backend menu builder.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BackendMenuBuilder extends AbstractMenuBuilder
{
    /**
     * Backend main menu factory.
     *
     * @param Request $request
     * @return ItemInterface
     */
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root', array());
    }

    /**
     * Backend sidebar menu factory.
     *
     * @param Request $request
     * @return ItemInterface
     */
    public function createSidebarMenu(Request $request)
    {
        $menu = $this->factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav',
                'id' => 'side-menu',
            )
        ));

        $this->attachTopLink($menu, 'dashboard', 'accard_backend_dashboard', 'fa fa-dashboard fa-fw');
        $this->attachTopItem($menu, 'design', 'fa fa-file fa-fw');
        $this->attachTopItem($menu, 'users', 'fa fa-user fa-fw');
        $this->attachTopLink($menu, 'options', 'accard_backend_option_index', 'fa fa-list fa-fw');
        $this->attachTopItem($menu, 'settings', 'fa fa-wrench fa-fw');

        $event = $this->createMenuEvent($menu, $request);
        $this->eventDispatcher->dispatch(MenuEvents::BACKEND_SIDEBAR, $event);

        return $menu;
    }

    private function attachTopItem(ItemInterface $menu, $name, $icon)
    {
        return $menu
            ->addChild($name, array('labelAttributes' => array('icon' => $icon)))
            ->setLabel($this->translate("accard.menu.backend.$name"));
    }

    private function attachTopLink(ItemInterface $menu, $name, $route, $icon)
    {
        return $menu
            ->addChild($name, array(
                'labelAttributes' => array('icon' => $icon),
                'route' => $route,
            ))
            ->setLabel($this->translate("accard.menu.backend.$name"));
    }
}
