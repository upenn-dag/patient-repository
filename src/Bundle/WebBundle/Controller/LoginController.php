<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\Controller;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * Login action.
     *
     * @param Request $request
     * @var Response
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        $errCode = SecurityContextInterface::AUTHENTICATION_ERROR;

        if ($request->attributes->has($errCode)) {
            $error = $request->attributes->get($errCode);
        } elseif (null !== $session && $session->has($errCode)) {
            $error = $session->get($errCode);
            $session->remove($errCode);
        }

        if (isset($error)) {
            $session->getBag('flashes')->add('error', $error);
        }

        $lastUsername = null === $session ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return $this->render(
            'AccardWebBundle:Common\Login:login.html.twig',
            array(
                'username' => $lastUsername,
            )
        );
    }
}
