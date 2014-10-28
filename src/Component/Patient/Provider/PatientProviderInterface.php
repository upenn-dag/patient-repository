<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Patient\Provider;

use Doctrine\Common\Collections\Collection;
use Accard\Component\Resource\Provider\ProviderInterface;
use Accard\Component\Patient\Model\PatientInterface;

/**
 * Patient provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PatientProviderInterface extends ProviderInterface
{
    /**
     * Get all patients.
     *
     * @return Collection|PatientInterface[]
     */
    public function getPatients();

    /**
     * Get patient by id.
     *
     * @throws PatientNotFoundException If patient is not found.
     * @param integer $patientId
     * @return PatientInterface
     */
    public function getPatient($patientId);

    /**
     * Get patient by MRN.
     *
     * @throws PatientNotFoundException If patient is not found.
     * @param string $patientMrn
     * @return PatientInterface
     */
    public function getPatientByMRN($patientMrn);
}
