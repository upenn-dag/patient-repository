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

use Accard\Bundle\DiagnosisBundle\Doctrine\ORM\CodeRepository;
use Accard\Bundle\DiagnosisBundle\Exception\CodeNotFoundException;
use Accard\Component\Diagnosis\Model\CodeInterface;

/**
 * Diagnosis code provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeProvider
{
    /**
     * Code repository.
     *
     * @var CodeRepository
     */
    private $repository;

    /**
     * Code group provider.
     *
     * @var CodeGroupProvider
     */
    private $codeGroupProvider;

    /**
     * Constructor.
     *
     * @param CodeRepository $repository
     */
    public function __construct(CodeRepository $repository,
                                CodeGroupProvider $codeGroupProvider)
    {
        $this->repository = $repository;
        $this->codeGroupProvider = $codeGroupProvider;
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
     * @return CodeRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Get code.
     *
     * @throws CodeNotFoundException If code can not be located.
     * @param string $codeString
     * @return CodeInterface
     */
    public function getCode($codeString)
    {
        $code = $this->repository->findOneByCode($codeString);

        if (!$code) {
            throw new CodeNotFoundException($codeString);
        }

        return $code;
    }

    /**
     * Get codes for a group.
     *
     * @param string $groupString
     * @return array
     */
    public function getCodesForGroup($groupString)
    {
        $group = $this->codeGroupProvider->getGroup($groupString);

        return $group->getCodes();
    }
}
