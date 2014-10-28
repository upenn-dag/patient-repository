<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PatientBundle\Provider;

use Accard\Component\Patient\Model\PatientInterface;
use Accard\Component\Patient\Provider\PatientProviderInterface;
use Accard\Component\Patient\Repository\PatientRepositoryInterface;
use Accard\Component\Patient\PatientNotFoundException;

/**
 * Patient provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientProvider implements PatientProviderInterface
{
    /**
     * Patient repository.
     *
     * @var PatientRepositoryInterface
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param PatientRepositoryInterface $repositry
     */
    public function __construct(PatientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getPatient($patientId)
    {
        if (!$patient = $this->repository->find($patientId)) {
            throw new PatientNotFoundException($patientId);
        }

        return $patient;
    }

    /**
     * {@inheritdoc}
     */
    public function getPatientByMRN($patientMrn)
    {
        if (!$patient = $this->repository->findOneByMrn($patientMrn)) {
            throw new PatientNotFoundException('MRN', $patientMrn);
        }

        return $patient;
    }
}
