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
 * Blame interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface BlameableInterface
{
    /**
     * Get creating user.
     *
     * @return mixed
     */
    public function getCreatedBy();

    /**
     * Set creating user.
     *
     * @param mixed $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy);

    /**
     * Get update user.
     *
     * @return mixed
     */
    public function getUpdatedBy();

    /**
     * Set update user.
     *
     * @param mixed $updatedBy;
     */
    public function setUpdatedBy(UserInterface $updatedBy);
}
