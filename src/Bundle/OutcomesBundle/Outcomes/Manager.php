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

use Doctrine\Common\Collections\Criteria;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Accard\Bundle\OutcomesBundle\Exception\ManagerNotInitializedException;
use Accard\Bundle\OutcomesBundle\Exception\TargetNotFoundException;
use Accard\Bundle\OutcomesBundle\Exception\TargetPrototypeNotFoundException;
use Accard\Bundle\CoreBundle\State\StateInstance;


/**
 * Outcomes manager.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Manager extends ContainerAware
{
    /**
     * State instance.
     *
     * @var StateInstance
     */
    private $state;

    /**
     * Filter registry.
     *
     * @var FilterRegistry
     */
    private $filterRegistry;


    /**
     * Constructor.
     *
     * @param FilterRegistry $filterRegistry
     */
    public function __construct(FilterRegistry $filterRegistry)
    {
        $this->filterRegistry = $filterRegistry;
    }

    /**
     * Set state on which to operate.
     *
     * @param StateInstance $state
     */
    public function setState(StateInstance $state)
    {
        $this->state = $state;
    }

    /**
     * Create an active configuration.
     *
     * @param ConfigurationInterface $configuration
     * @return ActiveConfiguration
     */
    public function createActiveConfig(ConfigurationInterface $config)
    {
        $this->assertRequirementsMet();

        return new ActiveConfiguration($config, $this->state);
    }

    /**
     * Create base database from configuration.
     *
     * @param ConfigurationInterface $config
     * @param integer|null $limit
     * @return BaseDataset
     */
    public function createBaseDataset(ConfigurationInterface $config, $limit = null)
    {
        $result = $this
            ->createBaseDatasetQueryBuilder($config)
            ->getQuery()
            ->setMaxResults($limit)
            ->getResult();

        return new BaseDataset($config, $result);
    }

    /**
     * Create base dataset for configuration.
     *
     * @param ConfigurationInterface $config
     * @return QueryBuilder
     */
    public function createBaseDatasetQueryBuilder(ConfigurationInterface $config)
    {
        if (!$config instanceof ActiveConfigurationInterface) {
            $config = $this->createActiveConfig($config);
        }

        $target = $config->getTarget();
        $queryBuilder = $this->getTargetQueryBuilder($target);

        if ($target->isPrototyped()) {
            $actualPrototype = $this->getTargetPrototype($target, $config->getTargetPrototype());
            $queryBuilder->filterByColumn("prototype", $actualPrototype);
        }

        // Now we add the filters from the active configuration...

        return $queryBuilder;
    }

    /**
     * Get query builder for a target.
     *
     * @param ... $target
     * @return QueryBuilder
     */
    private function getTargetQueryBuilder($target)
    {
        // This needs to be better...
        $repository = sprintf("accard.repository.%s", $target->getName());
        $repository = $this->container->get($repository);

        return $repository->getQueryBuilder();
    }

    /**
     * Get prototype for our target prototype.
     *
     * @throws TargetPrototypeNotFoundException If prototype can not be located.
     * @param ... $target
     * @param ... $prototype
     * @return PrototypeInterface
     */
    private function getTargetPrototype($target, $prototype)
    {
        // This needs to be better...
        $repository = sprintf("accard.repository.%s_prototype", $target->getName());
        $repository = $this->container->get($repository);

        $actualPrototype = $repository->findOneByName($prototype->getName());

        if (!$actualPrototype) {
            throw new TargetPrototypeNotFoundException($prototype->getName());
        }

        return $actualPrototype;
    }

    /**
     * Ensure all requirements are met for running this manager.
     *
     * @throws ManagerNotInitializedException If prerequisites are not met.
     */
    private function assertRequirementsMet()
    {
        if (null === $this->container || null === $this->state) {
            throw new ManagerNotInitializedException();
        }
    }
}
