<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle\Provider;

use Accard\Component\Diagnosis\Provider\DiagnosisProviderInterface;
use Accard\Component\Diagnosis\Repository\DiagnosisRepositoryInterface;
use Accard\Component\Diagnosis\Exception\DiagnosisNotFoundException;

/**
 * Diagnosis provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisProvider implements DiagnosisProviderInterface
{
    /**
     * Diagnosis repository.
     *
     * @var DiagnosisRepositoryInterface
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param DiagnosisRepositoryInterface $repository
     */
    public function __construct(DiagnosisRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getDiagnoses()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function getDiagnosis($diagnosisId)
    {
        if (!$diagnosis = $this->repository->find($diagnosisId)) {
            throw new DiagnosisNotFoundException($diagnosisId);
        }

        return $diagnosis;
    }

    /**
     * {@inheritdoc}
     */
    public function getDiagnosesByCode(CodeInterface $code)
    {
        return $this->repository->findBy(array('code' => $code));
    }
}
