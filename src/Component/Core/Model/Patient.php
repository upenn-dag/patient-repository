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
use Accard\Component\Patient\Model\Patient as BasePatient;
use DAG\Component\Option\Model\OptionValueInterface;
use DAG\Component\Resource\Model\ImportSubjectInterface;
use DateTime;

/**
 * Accard patient model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Patient extends BasePatient implements PatientInterface, ImportSubjectInterface
{
    // Traits
    use \DAG\Component\Resource\Model\BlameableTrait;
    use \DAG\Component\Resource\Model\TimestampableTrait;
    use \DAG\Component\Resource\Model\VersionableTrait;
    use \DAG\Component\Resource\Model\ImportSubjectTrait;

    /**
     * Diagnoses.
     *
     * @var Collection|ActivityInterface[]
     */
    protected $diagnoses;

    /**
     * Activities.
     *
     * @var Collection|ActivityInterface[]
     */
    protected $activities;

    /**
     * Behaviors.
     *
     * @var Collection|BehaviorInterface[]
     */
    protected $behaviors;

    /**
     * Attributes.
     *
     * @var Collection|AttributeInterface[]
     */
    protected $attributes;

    /**
     * Phases.
     *
     * @var Collection|PatientPhaseInstanceInterface[]
     */
    protected $phases;

    /**
     * Regimens.
     *
     * @var Collection|RegimenInterface[]
     */
    protected $regimens;

    /**
     * Samples.
     *
     * @var Collection|RegimenInterface[]
     */
    protected $samples;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->diagnoses = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->behaviors = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->phases = new ArrayCollection();
        $this->regimens = new ArrayCollection();
        $this->samples = new ArrayCollection();

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getDiagnoses()
    {
        return $this->diagnoses;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDiagnosis(DiagnosisInterface $diagnosis)
    {
        return $this->diagnoses->contains($diagnosis);
    }

    /**
     * {@inheritdoc}
     */
    public function addDiagnosis(DiagnosisInterface $diagnosis)
    {
        if (!$this->hasDiagnosis($diagnosis)) {
            $diagnosis->setPatient($this);
            $this->diagnoses->add($diagnosis);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeDiagnosis(DiagnosisInterface $diagnosis)
    {
        if ($this->hasDiagnosis($diagnosis)) {
            $this->diagnoses->removeElement($diagnosis);
            $diagnosis->setPatient(null);
        }

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
            $activity->setPatient($this);
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
            $activity->setPatient(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBehaviors()
    {
        return $this->behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function hasBehavior(BehaviorInterface $behavior)
    {
        return $this->behaviors->contains($behavior);
    }

    /**
     * {@inheritdoc}
     */
    public function addBehavior(BehaviorInterface $behavior)
    {
        if (!$this->hasBehavior($behavior)) {
            $behavior->setPatient($this);
            $this->behaviors->add($behavior);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeBehavior(BehaviorInterface $behavior)
    {
        if ($this->hasBehavior($behavior)) {
            $this->behaviors->removeElement($behavior);
            $behavior->setPatient(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function hasAttribute(AttributeInterface $attribute)
    {
        return $this->attributes->contains($attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function addAttribute(AttributeInterface $attribute)
    {
        if (!$this->hasAttribute($attribute)) {
            $attribute->setPatient($this);
            $this->attributes->add($attribute);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAttribute(AttributeInterface $attribute)
    {
        if ($this->hasAttribute($attribute)) {
            $this->attributes->removeElement($attribute);
            $attribute->setPatient(null);
        }

        return $this;
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
    public function hasPhase(PatientPhaseInstanceInterface $phase)
    {
        return $this->phases->contains($phase);
    }

    /**
     * {@inheritdoc}
     */
    public function addPhase(PatientPhaseInstanceInterface $phase)
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
    public function removePhase(PatientPhaseInstanceInterface $phase)
    {
        if ($this->hasPhase($phase)) {
            $this->phases->removeElement($phase);
            $phase->setTarget(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRegimens()
    {
        return $this->regimens;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRegimen(RegimenInterface $regimen)
    {
        return $this->regimens->contains($regimen);
    }

    /**
     * {@inheritdoc}
     */
    public function addRegimen(RegimenInterface $regimen)
    {
        if (!$this->hasRegimen($regimen)) {
            $regimen->setPatient($this);
            $this->regimens->add($regimen);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeRegimen(RegimenInterface $regimen)
    {
        if ($this->hasRegimen($regimen)) {
            $this->regimens->removeElement($regimen);
            $regimen->setPatient(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSamples()
    {
        return $this->samples;
    }

    /**
     * {@inheritdoc}
     */
    public function hasSample(SampleInterface $sample)
    {
        return $this->samples->contains($sample);
    }

    /**
     * {@inheritdoc}
     */
    public function addSample(SampleInterface $sample)
    {
        if (!$this->hasSample($sample)) {
            $sample->setPatient($this);
            $this->samples->add($sample);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSample(SampleInterface $sample)
    {
        if ($this->hasSample($sample)) {
            $this->samples->removeElement($sample);
            $sample->setPatient(null);
        }

        return $this;
    }
}
