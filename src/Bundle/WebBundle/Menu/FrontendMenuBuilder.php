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
 * Frontend menu builder.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FrontendMenuBuilder extends AbstractMenuBuilder
{
    /**
     * Frontend main menu factory.
     *
     * @param Request $request
     * @return ItemInterface
     */
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root', array());
    }

    /**
     * Frontend sidebar menu factory.
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

        $this->attachTopLink($menu, 'home', 'accard_frontend_homepage', 'fa fa-home fa-fw');
        $this->attachTopItem($menu, 'repositories', 'fa fa-archive fa-fw');

        if ($this->securityContext->isGranted('ROLE_ADMIN')) {
            $admin = $this->attachTopLink($menu, 'admin', 'accard_backend_dashboard', 'fa fa-dashboard fa-fw');
        }


        $event = $this->createMenuEvent($menu, $request);
        $this->eventDispatcher->dispatch(MenuEvents::FRONTEND_SIDEBAR, $event);

        return $menu;
    }

    private function attachTopItem(ItemInterface $menu, $name, $icon = null)
    {
        return $menu
            ->addChild($name, array('labelAttributes' => array('icon' => $icon)))
            ->setLabel($this->translate("accard.menu.frontend.$name"));
    }

    private function attachTopLink(ItemInterface $menu, $name, $route, $icon = null)
    {
        return $menu
            ->addChild($name, array(
                'labelAttributes' => array('icon' => $icon),
                'route' => $route,
            ))
            ->setLabel($this->translate("accard.menu.frontend.$name"));
    }
}
