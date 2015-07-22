<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Patient\Repository;

use DAG\Component\Resource\Repository\RepositoryInterface;

/**
 * Patient repository interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PatientRepositoryInterface extends RepositoryInterface
{
    /**
     * Get patient by name.
     *
     * Parses patient name, and uses the values found to perform a search on the
     * first and last name (last name is optional).
     *
     * @uses Accard\Component\Patient\Utils::parseName()
     * @param string $patientName
     * @return PatientInterface
     */
    public function getByName($patientName);
}
