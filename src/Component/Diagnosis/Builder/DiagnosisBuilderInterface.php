<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Diagnosis\Builder;

use DAG\Component\Resource\Builder\BuilderInterface;

/**
 * Diagnosis builder interface.
 *
 * Used to ease the programatic creation of diagnosiss.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface DiagnosisBuilderInterface extends BuilderInterface
{
    /**
     * Create a new diagnosis.
     *
     * @return DiagnosisBuilderInterface
     */
    public function create();
}
