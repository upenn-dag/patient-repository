<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Diagnosis\Model;

use DAG\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;

/**
 * Patient to field relation interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
interface FieldValueInterface extends BaseFieldValueInterface
{
    /**
     * Get diagnosis.
     *
     * @return DiagnosisInterface|null
     */
    public function getDiagnosis();

    /**
     * Set diagnosis.
     *
     * @param PatientInterface|null $diagnosis
     * @return FieldValueInterface
     */
    public function setDiagnosis(DiagnosisInterface $diagnosis = null);
}
