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

use DAG\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;

/**
 * Sample sample field value model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldValueInterface extends BaseFieldValueInterface
{
    /**
     * Get sample.
     *
     * @return SampleInterface|null
     */
    public function getSample();

    /**
     * Set sample.
     *
     * @param SampleInterface|null $sample
     * @return FieldValueInterface
     */
    public function setSample(SampleInterface $sample = null);
}
