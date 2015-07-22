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

use DAG\Component\Field\Model\FieldValue as BaseFieldValue;

/**
 * Patient to field value relation.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValue extends BaseFieldValue implements FieldValueInterface
{
    /**
     * {@inheritdoc}
     */
    public function getPatient()
    {
        return parent::getSubject();
    }

    /**
     * {@inheritdoc}
     */
    public function setPatient(PatientInterface $patient = null)
    {
        return parent::setSubject($patient);
    }
}
