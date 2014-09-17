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

use Accard\Bundle\DiagnosisBundle\Doctrine\ORM\DiagnosisRepository;
use Accard\Bundle\DiagnosisBundle\Exception\DiagnosisNotFoundException;
use Accard\Component\Diagnosis\Model\DiagnosisInterface;

/**
 * Diagnosis provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisProvider
{
    /**
     * Diagnosis repository.
     *
     * @var DiagnosisRepository
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param DiagnosisRepository $repository
     */
    public function __construct(DiagnosisRepository $repository,
                                CodeProvider $codeProvider,
                                CodeGroupProvider $codeGroupProvider)
    {
        $this->repository = $repository;
        $this->codeProvider = $codeProvider;
        $this->codeGroupProvider = $codeGroupProvider;
    }

    /**
     * Get code provider.
     *
     * @return CodeProvider
     */
    public function getCodeProvider()
    {
        return $this->codeProvider;
    }

    /**
     * Get code group provider.
     *
     * @return CodeGroupProvider
     */
    public function getCodeGroupProvider()
    {
        return $this->codeGroupProvider;
    }

    /**
     * Get repository.
     *
     * @return DiagnosisRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Get diangnosis by id.
     *
     * @throws DiagnosisNotFoundException If diagnosis is not found and strict search is enabled
     * @param integer $id
     * @param boolean $strict
     * @return DiagnosisInterface|null
     */
    public function getDiagnosis($id, $strict = true)
    {
        $diagnosis = $this->repository->find($id);

        if ($strict && !$diagnosis) {
            throw new DiagnosisNotFoundException($id);
        } elseif (!$strict && !$diagnosis) {
            return;
        }

        return $diagnosis;
    }
}
