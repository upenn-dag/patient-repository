<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Initlializable controller.
 *
 * Enables a controller to run security in a common method prior to ever
 * executing the controller action. This gives us a simplified way to run
 * security checks on a per-controller basis.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface InitializableController
{
    /**
     * Before controller action.
     *
     * @param Request $request
     * @param AuthorizationCheckerInterface $authChecker
     */
    public function initialize(Request $request, AuthorizationCheckerInterface $authChecker);
}
