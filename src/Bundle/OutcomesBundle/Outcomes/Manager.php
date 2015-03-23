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
     * Base dataset actory builder.
     *
     * At the moment, we only need one of these ever. So we'lll cache it.
     *
     * @var BaseDatasetFactoryBuilder
     */
    private $factoryBuilderCache;


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
     * @param ConfigurationInterface $config
     * @return ActiveConfiguration
     */
    public function createActiveConfig(ConfigurationInterface $config)
    {
        $this->assertRequirementsMet();

        return new ActiveConfiguration($config, $this->state, $this->filterRegistry);
    }

    /**
     * Create a base dataset factory builder.
     *
     * @todo Remove dependency on the container, it's ugly.
     * @return BaseDatasetFactoryBuilder
     */
    public function createBaseDatasetFactoryBuilder()
    {
        $this->assertRequirementsMet();

        if (null == $this->factoryBuilderCache) {
            $this->factoryBuilderCache = new BaseDatasetFactoryBuilder($this->container);
        }

        return $this->factoryBuilderCache;
    }

    /**
     * Generate a base dataset factory for a given configuration.
     *
     * @param ConfigurationInterface $config
     * @return BaseDatasetFactory
     */
    public function createBaseDatasetFactory(ConfigurationInterface $config)
    {
        if ($config instanceof ActiveConfigurationInterface) {
            $config = $config->getOriginalConfig();
        }

        return $this->createBaseDatasetFactoryBuilder()->create($config->getTarget());
    }

    /**
     * Generate a base dataset for a given configuration.
     *
     * @param ConfigurationInterface $config
     * @return BaseDataset
     */
    public function createBaseDataset(ConfigurationInterface $config)
    {
        if (!$config instanceof ActiveConfigurationInterface) {
            $config = $this->createActiveConfig($config);
        }

        return $this->createBaseDatasetFactory($config)->create($config);
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
