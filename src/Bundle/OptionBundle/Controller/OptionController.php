<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OptionBundle\Controller;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Accard\Bundle\ResourceBundle\Controller\ResourceController;
use Accard\Component\Option\Provider\OptionProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Option controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionController extends ResourceController
{
    /**
     * Forwards you to named option update.
     *
     * @param Request $request
     * @param string $name
     */
    public function redirectNameAction(Request $request, $name)
    {
        if (!$route = $this->config->getRedirectRoute(null)) {
            throw new RouteNotFoundException('Option redirect route must be configured with _accard.redirect parameter.');
        }

        $option = $this->getOptionProvider()->getOption($name);

        return $this->redirect($this->generateUrl($route, array('id' => $option->getId())));
    }

    /**
     * Get option repository.
     *
     * @return OptionProviderInterface
     */
    private function getOptionProvider()
    {
        return $this->get('accard.option.provider');
    }
}
