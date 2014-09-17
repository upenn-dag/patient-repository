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

use Accard\Bundle\DiagnosisBundle\Doctrine\ORM\CodeGroupRepository;
use Accard\Bundle\DiagnosisBundle\Exception\CodeGroupNotFoundException;
use Accard\Component\Diagnosis\Model\CodeGroupInterface;

/**
 * Diagnosis code provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeGroupProvider
{
    /**
     * Code group repository.
     *
     * @var CodeGroupRepository
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param CodeGroupRepository $repository
     */
    public function __construct(CodeGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get repository.
     *
     * @return CodeGroupRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Get code group.
     *
     * @throws CodeGroupNotFoundException If code can not be located.
     * @param string $name
     * @return CodeGroupInterface
     */
    public function getGroup($name)
    {
        $group = $this->repository->findOneByName($name);

        if (!$group) {
            throw new CodeGroupNotFoundException($name);
        }

        return $group;
    }

    /**
     * Get all code groups.
     *
     * @throws CodeGroupNotFoundException If code can not be located.
     * @return CodeGroupInterface
     */
    public function getGroups()
    {
        return  $this->repository->findAll();
    }
}
