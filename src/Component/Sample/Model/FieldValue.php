<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Sample\Model;

use DAG\Component\Field\Model\FieldValue as BaseFieldValue;

/**
 * Accard sample field value model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValue extends BaseFieldValue implements FieldValueInterface
{
    /**
     * Sample.
     *
     * @var SampleInterface|null
     */
    //protected $sample;


    /**
     * {@inheritdoc}
     */
    public function getSample()
    {
        return parent::getSubject();
    }

    /**
     * {@inheritdoc}
     */
    public function setSample(SampleInterface $sample = null)
    {
        return parent::setSubject($sample);
    }
}
