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

/**
 * Accard activity trait.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait ActivityTrait
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
}
