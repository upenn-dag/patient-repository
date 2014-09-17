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
 * Timestampable trait.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait TimestampableTrait
{
    /**
     * Creation date.
     *
     * @var DateTime
     */
    protected $createdAt;

    /**
     * Update date.
     *
     * @var DateTime
     */
    protected $updatedAt;


    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
