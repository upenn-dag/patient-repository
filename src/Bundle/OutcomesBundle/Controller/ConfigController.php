<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController as Controller;

/**
 * Accard outcomes controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ConfigController extends Controller
{
    public function getConfigsAction()
    {
        $configs = array();

        $view = $this->view($configs, 200)
            ->setTemplate("AccardOutcomesBundle:Config:index.html.twig")
            ->setTemplateVar("configs")
        ;

        return $this->handleView($view);
    }


    public function getConfigAction($id)
    {
        // Programatically create a configuration, this should
        // be replaced with a more dynamic action.
        $config = new \Accard\Bundle\OutcomesBundle\Outcomes\Configuration($state);
        $config->setTarget("activity");
        $config->setTargetPrototype("radiation");
        $dateFilter = $config->createFilterConfig("between", array("type" => "datetime", "start" => "01/01/2000", "end" => "now"));
        $cycleFilter = $config->createFilterConfig("between", array("type" => "number", "start" => 2, "end" => 5));
        $config->setFilter("activityDate", $dateFilter);
        $config->setFilter("cycles", $cycleFilter);

        $view = $this->view($config, 200)
            ->setTemplate("AccardOutcomesBundle:Config:show.html.twig")
            ->setTemplateVar("config")
        ;

        return $this->handleView($view);
    }
}
