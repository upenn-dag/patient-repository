<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Regimen\Model;

use Accard\Component\Field\Model\FieldValue as BaseFieldValue;

/**
 * Accard sample field value model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValue extends BaseFieldValue implements FieldValueInterface
{
    /**
     * Regimen.
     *
     * @var RegimenInterface|null
     */
    //protected $sample;


    /**
     * {@inheritdoc}
     */
    public function getRegimen()
    {
        return parent::getSubject();
    }

    /**
     * {@inheritdoc}
     */
    public function setRegimen(RegimenInterface $sample = null)
    {
        return parent::setSubject($sample);
    }
}
