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
 * Lockable model trait.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait LockableTrait
{
    /**
     * Model locked?
     *
     * @var boolean
     */
    protected $locked = false;

    /**
     * {@inheritdoc}
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function lock()
    {
        $this->locked = true;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function unlock()
    {
        $this->locked = false;

        return $this;
    }
}
