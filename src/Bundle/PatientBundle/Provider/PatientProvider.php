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

use Doctrine\ORM\NonUniqueResultException;
use Accard\Component\Patient\Model\PatientInterface;
use Accard\Component\Patient\Provider\PatientProviderInterface;
use Accard\Component\Patient\Repository\PatientRepositoryInterface;
use Accard\Component\Patient\Exception\PatientNotFoundException;
use Accard\Component\Patient\Exception\MultiplePatientsFoundException;

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
    public function getPatients()
    {
        return $this->repository->findAll();
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

    /**
     * {@inheritdoc}
     */
    public function getPatientByName($patientName)
    {
        try {
            if (!$patient = $this->repository->getByName($patientName)) {
                throw new PatientNotFoundException('name', $patientName);
            }
        } catch (NonUniqueResultException $exception) {
            throw new MultiplePatientsFoundException();
        }

        return $patient;
    }
}
