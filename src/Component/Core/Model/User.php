<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Core\Model;

/**
 * Accard user.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class User implements UserInterface
{
    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    public function getPassword()
    {
        return '';
    }

    public function getSalt()
    {
        return '';
    }

    public function getUsername()
    {
        return 'username';
    }

    public function eraseCredentials()
    {
        // Do something.
    }
}
