<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\UserBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Cache\Cache;
use Accard\Bundle\UserBundle\Security\User\PennUser;
use Accard\Bundle\UserBundle\Client\PennDirectoryServices;
use Accard\Bundle\UserBundle\Client\PenngroupsClient;

/**
 * Penn-based user provider implementation
 *
 * @author Michael Woods <micwoods@mail.med.upenn.edu>
 */
class PennUserProvider implements UserProviderInterface
{
    /**
     * Penn directory client.
     *
     * @var PennDirectoryServices
     */
    private $dirClient;

    /**
     * Penn groups client.
     *
     * @var PennGroupsCient
     */
    private $groupsClient;

    /**
     * Constructor.
     *
     * @param PennDirectoryServices $dirClient
     * @param PenngroupsClient $groupsClient
     */
    public function __construct(\DAG\Penn\Directory\Client $dirClient, \DAG\Penn\Groups\Client $groupsClient)
    {
        $this->dirClient    = $dirClient;
        $this->groupsClient = $groupsClient;
    }

    /**
     * Loads a user from the directory service by the given username
     *
     * An additional check for SSL enabled LDAP communication is run. We require
     * secure LDAP in production environments.
     *
     * @param  string $username
     * @return UserInterface
     */
    public function loadUserByUsername($username)
    {
        $attributes = null;

        if (null === ($attributes = $this->dirClient->findByPennKey($username))) {
            throw new BadCredentialsException("'{$username}' is not a valid username");
        }

        $attributes['id'] = $this->groupsClient->translatePennKeyToID($username);

        if (null === $attributes['id']) {
            throw new BadCredentialsException("No PennID corresponds to the given username '{$username}'");
        }

        $attributes['groups'] = $this->groupsClient->getGroups($attributes['id']);

        $user = new PennUser(
            $attributes['id'],
            $attributes['uid'],
            isset($attributes['givenName']) ? $attributes['givenName'] : "",
            $attributes['sn'],
            isset($attributes['title']) ? $attributes['title'] : null,
            isset($attributes['mail']) ? $attributes['mail'] : null,
            isset($attributes['telephoneNumber']) ? $attributes['telephoneNumber'] : null,
            $attributes['groups']
        );

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        /** @see http://symfony.com/doc/current/cookbook/security/api_key_authentication.html */
        throw new UnsupportedUserException();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === 'Accard\Bundle\UserBundle\Security\User';
    }
}
