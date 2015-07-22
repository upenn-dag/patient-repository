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

use DAG\Component\Field\Model\FieldValue as BaseFieldValue;

/**
 * Patient to field value relation.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class FieldValue extends BaseFieldValue implements FieldValueInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDiagnosis()
    {
        return parent::getSubject();
    }

    /**
     * {@inheritdoc}
     */
    public function setDiagnosis(DiagnosisInterface $diagnosis = null)
    {
        return parent::setSubject($diagnosis);
    }
}
