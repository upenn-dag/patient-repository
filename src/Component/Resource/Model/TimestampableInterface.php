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

use DateTime;

/**
 * Timestamp interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface TimestampableInterface
{
    /**
     * Get creation date.
     *
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * Set creation date.
     *
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt);

    /**
     * Get update date.
     *
     * @return DateTime
     */
    public function getUpdatedAt();

    /**
     * Set update date.
     *
     * @param DateTime $updatedAt;
     */
    public function setUpdatedAt(DateTime $updatedAt);
}
