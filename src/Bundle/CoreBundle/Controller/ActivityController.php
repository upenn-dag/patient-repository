<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Controller;

use Accard\Bundle\ResourceBundle\Controller\ResourceController;
use Accard\Bundle\SettingsBundle\Model\Settings;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;

/**
 * Activity controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityController extends ResourceController
{
    /**
     * Design activity action.
     *
     * @param Request $request
     */
    public function designAction(Request $request)
    {
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('design.html'))
            ->setData(array(
                'prototypes' => $this->getPrototypes(),
                'activity_count' => $this->getActivityCount(),
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Get activity prototypes.
     * 
     * @return array
     */
    private function getPrototypes()
    {
        return $this->get('accard.repository.activity_prototype')->createPaginator();
    }

    /**
     * Get the total number of activities.
     *
     * @return integer
     */
    private function getActivityCount()
    {
        return $this->get('accard.repository.activity')->getCount();
    }
}
