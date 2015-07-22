<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Outcomes;

use Accard\Bundle\OutcomesBundle\Exception\TargetNotFoundException;
use Accard\Bundle\OutcomesBundle\Exception\TargetPrototypeNotFoundException;
use DAG\Component\Resource\Repository\RepositoryInterface;
use DAG\Component\Prototype\Repository\PrototypeRepositoryInterface;

/**
 * Base dataset factory.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BaseDatasetFactory
{
    /**
     * Base dataset repository.
     *
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Base dataset prototype repository.
     *
     * @var PrototypeRepositoryInterface
     */
    private $prototypeRepository;


    /**
     * Constructor.
     *
     * @param RepositoryInterface $repository
     * @param PrototypeRepositoryInterface $prototypeRepository
     */
    public function __construct(RepositoryInterface $repository,
                                PrototypeRepositoryInterface $prototypeRepository = null)
    {
        $this->repository = $repository;
        $this->prototypeRepository = $prototypeRepository;
    }

    /**
     * Create base database from configuration.
     *
     * @param ActiveConfigurationInterface $config
     * @param integer|null $limit
     * @return BaseDataset
     */
    public function create(ActiveConfigurationInterface $config, $limit = null)
    {
        $result = $this
            ->createQueryBuilder($config)
            ->getQuery()
            ->setMaxResults($limit)
            ->getResult();

        return new BaseDataset($config, $result);
    }

    /**
     * Create base dataset for configuration.
     *
     * @throws TargetPrototypeNotFoundException If prototype is requested, but can not be located.
     * @param ActiveConfigurationInterface $config
     * @return QueryBuilder
     */
    public function createQueryBuilder(ActiveConfigurationInterface $config)
    {
        $target = $config->getTarget();
        $queryBuilder = $this->getTargetQueryBuilder($target);

        if ($target->isPrototyped()) {
            $prototype = $this->getTargetPrototype($target, $config->getTargetPrototype());

            if (!$prototype) {
                throw new TargetPrototypeNotFoundException($prototype->getName());
            }

            $queryBuilder->filterByColumn("prototype", $prototype);
        }

        return $queryBuilder;
    }

    /**
     * Get query builder for a target.
     *
     * @return QueryBuilder
     */
    private function getTargetQueryBuilder()
    {
        return $this->repository->getQueryBuilder();
    }

    /**
     * Get prototype for our target prototype.
     *
     * @param ... $prototype
     * @return PrototypeInterface|null
     */
    private function getTargetPrototype($prototype)
    {
        return $this->prototypeRepository->findOneByName($prototype->getName());
    }
}
