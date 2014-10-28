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
use Accard\Component\Regimen\Model\Regimen as BaseRegimen;
use DateTime;

/**
 * Accard regimen model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Regimen extends BaseRegimen implements RegimenInterface
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
     * Diagnosis.
     *
     * @var DiagnosisInterface
     */
    protected $diagnosis;

    /**
     * Activities.
     *
     * @var Collection|ActivityInterface[]
     */
    protected $activities;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->activities = new ArrayCollection();

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
    public function getDiagnosis()
    {
        return $this->diagnosis;
    }

    /**
     * {@inheritdoc}
     */
    public function setDiagnosis(DiagnosisInterface $diagnosis = null)
    {
        $this->diagnosis = $diagnosis;

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
            $activity->setRegimen($this);
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
            $activity->setRegimen(null);
        }
    }
}
