<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Model;

/**
 * Accard user model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class User implements UserInterface
{
    /**
     * Is user enabled?
     *
     * @var boolean
     */
    protected $enabled;


    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        return true; // Account expiration is not implemented.
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return true; // Account locking is not implemented.
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        return true; // Account credential expiration is not implemented.
    }

    /**
     * {@inheritdoc}
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
