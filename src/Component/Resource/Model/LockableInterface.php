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
 * Lockable model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface LockableInterface
{
    /**
     * Test if model is currently locked.
     *
     * @return boolean
     */
    public function isLocked();

    /**
     * Set locked.
     *
     * @param boolean $locked
     * @return LockableInterface
     */
    public function setLocked($locked);

    /**
     * Lock model.
     *
     * @return LockableInterface
     */
    public function lock();

    /**
     * Unlock model.
     *
     * @return LockableInterface
     */
    public function unlock();
}
