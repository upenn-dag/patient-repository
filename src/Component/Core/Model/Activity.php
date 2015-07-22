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

use Accard\Component\Activity\Model\Activity as BaseActivity;
use DateTime;

/**
 * Accard activity model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Activity extends BaseActivity implements ActivityInterface
{
    // Traits
    use \DAG\Component\Resource\Model\BlameableTrait;
    use \DAG\Component\Resource\Model\TimestampableTrait;
    use \DAG\Component\Resource\Model\VersionableTrait;

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
     * Regimen.
     *
     * @var RegimenInterface
     */
    protected $regimen;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();

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
    public function hasPatient()
    {
        return $this->patient instanceof PatientInterface;
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
    public function hasDiagnosis()
    {
        return $this->diagnosis instanceof DiagnosisInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function getRegimen()
    {
        return $this->regimen;
    }

    /**
     * {@inheritdoc}
     */
    public function setRegimen(RegimenInterface $regimen = null)
    {
        $this->regimen = $regimen;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRegimen()
    {
        return $this->regimen instanceof RegimenInterface;
    }
}
