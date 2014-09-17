<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Patient\Builder;

use Accard\Component\Resource\Builder\BuilderInterface;

/**
 * Patient builder interface.
 *
 * Used to ease the programatic creation of patients.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PatientBuilderInterface extends BuilderInterface
{
    /**
     * Create a new patient.
     *
     * @return PatientBuilderInterface
     */
    public function create();

    /**
     * Add field with name and value.
     *
     * @param string $name
     * @param mixed $value
     * @param string|null $presentation
     * @return PatientBuilderInterface
     */
    public function addField($name, $value, $presentation = null);
}
