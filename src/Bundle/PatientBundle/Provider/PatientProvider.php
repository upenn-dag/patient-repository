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
use Accard\Bundle\PatientBundle\Doctrine\ORM\PatientRepository;
use Accard\Bundle\PatientBundle\Exception\PatientNotFoundException;

/**
 * Patient provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientProvider
{
    /**
     * Patient repository.
     *
     * @var PatientRepository
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param PatientRepository $repositry
     */
    public function __construct(PatientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get patient by MRN.
     *
     * @throws PatientNotFoundException If patient is not found.
     * @param string $mrn
     * @return PatientInterface
     */
    public function getPatientByMRN($mrn)
    {
        if (!$patient = $this->repository->findOneByMrn($mrn)) {
            throw new PatientNotFoundException('MRN', $mrn);
        }

        return $patient;
    }
}
