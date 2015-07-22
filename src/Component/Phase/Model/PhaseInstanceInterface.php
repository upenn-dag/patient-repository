<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Phase\Model;

use DateTime;
use DAG\Component\Resource\Model\ResourceInterface;

/**
 * Basic phase instance interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PhaseInstanceInterface extends ResourceInterface
{
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Set id.
     *
     * @param integer | id
     * @return PhaseInstanceInterface
     */
    public function setId($id);

    /**
     * Get phase.
     *
     * @return PhaseInterface
     */
    public function getPhase();

    /**
     * Set phase.
     *
     * @param PhaseInterface $phase
     * @return PhaseInstanceInterface
     */
    public function setPhase(PhaseInterface $phase);

    /**
     * Get target.
     *
     * @return PhaseTargetInterface
     */
    public function getTarget();

    /**
     * Set target.
     *
     * @param PhaseTargetInterface|null $target
     * @return PhaseInstanceInterface
     */
    public function setTarget(PhaseTargetInterface $target = null);

    /**
     * Get start date.
     *
     * @return DateTime
     */
    public function getStartDate();

    /**
     * Set start date.
     *
     * @param DateTime $startDate
     * @return PhaseInstanceInterface
     */
    public function setStartDate(DateTime $startDate);

    /**
     * Get end date.
     *
     * @return DateTime|null $endDate
     */
    public function getEndDate();

    /**
     * Set end date.
     *
     * @param DateTime|null $endDate
     * @return PhaseInstanceInterface
     */
    public function setEndDate(DateTime $endDate = null);

    /**
     * Test if phase is ongoing.
     *
     * @return boolean
     */
    public function isOngoing();
}
