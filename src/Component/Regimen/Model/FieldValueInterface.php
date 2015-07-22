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

use DAG\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;

/**
 * Regimen sample field value model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldValueInterface extends BaseFieldValueInterface
{
    /**
     * Get sample.
     *
     * @return RegimenInterface|null
     */
    public function getRegimen();

    /**
     * Set sample.
     *
     * @param RegimenInterface|null $sample
     * @return FieldValueInterface
     */
    public function setRegimen(RegimenInterface $sample = null);
}
