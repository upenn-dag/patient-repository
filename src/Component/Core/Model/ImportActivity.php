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
use Accard\Component\Core\Model\ActivityTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Accard import activity model.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class ImportActivity extends BaseActivity implements ImportActivityInterface
{
    // Traits
    use \Accard\Component\Resource\Model\ImportTargetTrait;

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

    /**
     * {@inheritdoc}
     */
    public function hasDiagnosis()
    {
        return $this->diagnosis instanceof DiagnosisInterface;
    }
}
