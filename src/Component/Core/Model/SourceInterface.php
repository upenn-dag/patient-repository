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

use Accard\Component\Sample\Model\SourceInterface as BaseSourceInterface;

/**
 * Accard sample source interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SourceInterface extends BaseSourceInterface
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
     * Test for presence of a patient.
     *
     * @return boolean
     */
    public function hasPatient();
}
