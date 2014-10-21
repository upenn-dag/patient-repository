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

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Diagnosis\Model\Diagnosis as BaseDiagnosis;
use DateTime;

/**
 * Accard diagnosis model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Diagnosis extends BaseDiagnosis implements DiagnosisInterface
{
    // Traits
    use \Accard\Component\Resource\Model\BlameableTrait;
    use \Accard\Component\Resource\Model\TimestampableTrait;
    use \Accard\Component\Resource\Model\VersionableTrait;

    /**
     * Patient.
     *
     * @var PatientInterface
     */
    protected $patient;

    /**
     * Activities.
     *
     * @var Collection|ActivityInterface[]
     */
    protected $activities;

    /**
     * Phases.
     *
     * @var Collection|DiagnosisPhaseInstanceInterface[]
     */
    protected $phases;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->activities = new ArrayCollection();
        $this->phases = new ArrayCollection();

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * {@inheritdoc}
     */
    public function setPatient(PatientInterface $patient = null)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * {@inheritdoc}
     */
    public function hasActivity(ActivityInterface $activity)
    {
        return $this->activities->contains($activity);
    }

    /**
     * {@inheritdoc}
     */
    public function addActivity(ActivityInterface $activity)
    {
        if (!$this->hasActivity($activity)) {
            $activity->setTarget($this);
            $this->activities->add($activity);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeActivity(ActivityInterface $activity)
    {
        if ($this->hasActivity($activity)) {
            $this->activities->removeElement($activity);
            $activity->setTarget(null);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPhases()
    {
        return $this->phases;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPhase(DiagnosisPhaseInstanceInterface $phase)
    {
        return $this->phases->contains($phase);
    }

    /**
     * {@inheritdoc}
     */
    public function addPhase(DiagnosisPhaseInstanceInterface $phase)
    {
        if (!$this->hasPhase($phase)) {
            $phase->setTarget($this);
            $this->phases->add($phase);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removePhase(DiagnosisPhaseInstanceInterface $phase)
    {
        if ($this->hasPhase($phase)) {
            $this->phases->removeElement($phase);
            $phase->setTarget(null);
        }
    }
}
