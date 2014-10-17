<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Patient\Model;

/**
 * Patient collecting interface.
 *
 * Used by other classes to indicate that this model collects patient data.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PatientCollectingInterface
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
     * @param PatientInterface $patient
     * @return PatientCollectingInterface
     */
    public function setPatient(PatientInterface $patient = null);
}
