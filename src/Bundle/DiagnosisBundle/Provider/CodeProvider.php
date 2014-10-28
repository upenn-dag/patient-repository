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

use Accard\Component\Diagnosis\Provider\CodeProviderInterface;
use Accard\Component\Diagnosis\Repository\CodeRepositoryInterface;
use Accard\Component\Diagnosis\Exception\CodeNotFoundException;

/**
 * Diagnosis code provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeProvider implements CodeProviderInterface
{
    /**
     * Code repository.
     *
     * @var CodeRepository
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param CodeRepository $repository
     */
    public function __construct(CodeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getModelClass()
    {
        return $this->repository->getClassName();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCodes()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function getCode($codeId)
    {
        if (!$code = $this->repository->find($codeId)) {
            throw new CodeNotFoundException($codeId);
        }

        return $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getCodeByCode($codeString)
    {
        if (!$code = $this->repository->findOneByCode($codeId)) {
            throw new CodeNotFoundException('code', $codeId);
        }

        return $code;
    }
}
