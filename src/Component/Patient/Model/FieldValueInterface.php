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

use Accard\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;

/**
 * Patient to field relation interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldValueInterface extends BaseFieldValueInterface
{
    /**
     * Get patient.
     *
     * @return PatientInterface|null
     */
    public function getPatient();

    /**
     * Set patient.
     *
     * @param PatientInterface|null $patient
     * @return FieldValueInterface
     */
    public function setPatient(PatientInterface $patient = null);
}
