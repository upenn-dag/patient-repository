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

use DateTime;
use Accard\Component\Phase\Model\PhaseTargetInterface;
use Accard\Component\Phase\Model\PhaseInterface as BasePhaseInterface;

/**
 * Patient phase instance model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientPhaseInstance implements PatientPhaseInstanceInterface
{
    /**
     * Phase.
     *
     * @var PhaseInterface
     */
    protected $phase;

    /**
     * Phase target.
     *
     * @var PhaseTargetInterface
     */
    protected $target;

    /**
     * Start date.
     *
     * @var DateTime
     */
    protected $startDate;

    /**
     * End date.
     *
     * @var DateTime
     */
    protected $endDate;


    /**
     * {@inheritdoc}
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhase(BasePhaseInterface $phase)
    {
        $this->phase = $phase;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * {@inheritdoc}
     */
    public function setTarget(PhaseTargetInterface $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate(DateTime $endDate = null)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isOngoing()
    {
        return null === $this->endDate;
    }
}
