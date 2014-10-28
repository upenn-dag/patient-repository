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

use Doctrine\Common\Collections\Collection;
use Accard\Component\Diagnosis\Provider\CodeGroupProviderInterface;
use Accard\Component\Diagnosis\Repository\CodeGroupRepositoryInterface;
use Accard\Component\Diagnosis\Exception\CodeGroupNotFoundException;
use Accard\Component\Diagnosis\Model\CodeGroupInterface;

/**
 * Diagnosis code provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeGroupProvider implements CodeGroupProviderInterface
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
    public function __construct(CodeGroupRepositoryInterface $repository)
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
    public function getAllGroups()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function getGroup($groupId)
    {
        if (!$group = $this->repository->find($groupId)) {
            throw new CodeGroupNotFoundException($groupId);
        }

        return $group;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroupByName($groupName)
    {
        if (!$group = $this->repository->findOneByName($groupName)) {
            throw new CodeGroupNotFoundException('name', $groupName);
        }

        return $group;
    }
}
