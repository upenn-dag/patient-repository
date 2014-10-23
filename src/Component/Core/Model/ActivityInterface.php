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

use Accard\Component\Activity\Model\ActivityInterface as BaseActivityInterface;
use Accard\Component\Resource\Model\BlameableInterface;
use Accard\Component\Resource\Model\VersionableInterface;
use Accard\Component\Resource\Model\TimestampableInterface;

/**
 * Accard activity interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ActivityInterface extends BaseActivityInterface,
                                    TimestampableInterface,
                                    BlameableInterface,
                                    VersionableInterface
{
    /**
     * Get patient.
     *
     * @return PatientInterface
     */
    public function getPatient();

    /**
     * Set patient.
     *
     * @param PatientInterface|null $patient
     * @return ActivityInterface
     */
    public function setPatient(PatientInterface $patient = null);

    /**
     * Get diagnosis.
     *
     * @return DiagnosisInterface
     */
    public function getDiagnosis();

    /**
     * Set diagnosis.
     *
     * @param DiagnosisInterface|null $diagnosis
     * @return ActivityInterface
     */
    public function setDiagnosis(DiagnosisInterface $diagnosis = null);

    /**
     * Test for presence of a diagnosis.
     *
     * @return boolean
     */
    public function hasDiagnosis();

    /**
     * Get regimen.
     *
     * @return RegimenInterface
     */
    public function getRegimen();

    /**
     * Set regimen.
     *
     * @param RegimenInterface|null $regimen
     * @return ActivityInterface
     */
    public function setRegimen(RegimenInterface $regimen = null);

    /**
     * Test for presence of a regimen.
     *
     * @return boolean
     */
    public function hasRegimen();
}
