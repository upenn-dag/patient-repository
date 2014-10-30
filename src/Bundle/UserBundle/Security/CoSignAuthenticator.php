<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\UserBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Co-Sign authenticator.
 *
 * @author Michael Woods <micwoods@mail.med.upenn.edu>
 */
class CoSignAuthenticator implements SimplePreAuthenticatorInterface
{
    const USER_KEY = "REMOTE_USER";

    /**
     * {@inheritdoc}
     */
    public function createToken(Request $request, $key)
    {
        $user = $request->server->get(self::USER_KEY, null);

        if (empty($user)) {
            throw new BadCredentialsException(
                sprintf('$_SERVER[%s] has not been set.', self::USER_KEY)
            );
        }

        return new PreAuthenticatedToken($user, $user, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $provider, $key)
    {
        $creds = $token->getCredentials();
        $user = $provider->loadUserByUsername($creds);

        return new PreAuthenticatedToken($user, $creds, $key, $user->getRoles());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsToken(TokenInterface $token, $key)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $key;
    }
}
