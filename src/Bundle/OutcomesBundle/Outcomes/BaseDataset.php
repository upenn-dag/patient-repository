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

use ArrayIterator;
use LogicException;
use InvalidArgumentException;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Base dataset.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BaseDataset implements DatasetInterface
{
    /**
     * Filter a result set for a given configuration.
     *
     * @param ActiveConfigurationInterface $config
     * @param array $data
     * @return array
     */
    public static function filter(ActiveConfigurationInterface $config, array $data)
    {
        $data = new ArrayCollection($data);
        $filters = $config->getFields();
        $filterOptions = $config->getOriginalConfig()->getFields();
        $fields  = array_keys($filters);
        $criteria = Criteria::create();

        foreach ($fields as $field) {
            foreach ($filters[$field] as $key => $filter) {
                $resolver = new OptionsResolver();
                $filter->configureOptions($resolver);
                $options = $filter->resolveOptions($resolver, $filterOptions[$field][$key]->getOptions());
                $filter->filter($criteria, $config->getField($field), $options);
            }
        }

        return $data->matching($criteria)->getValues();
    }


    /**
     * Configuration object.
     *
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * Dataset data.
     *
     * @var array
     */
    protected $data;


    /**
     * Constructor.
     *
     * If data is set at construction time, we need to filter it. We may only do
     * so if we received an active configuration, otherwise we have to reject
     * the data.
     *
     * @param ConfigurationInterface $configuration
     * @param array $data
     * @param boolean $filter
     */
    public function __construct(ConfigurationInterface $configuration, array $data = array(), $filter = true)
    {
        $this->setConfiguration($configuration);

        if (!empty($data)) {
            if (!$configuration instanceof ActiveConfigurationInterface) {
                throw new LogicException("You may only set data at construction time if you provide an active configuration.");
            }

            $data = $filter ? static::filter($configuration, $data) : $data;
        }

        $this->setData($data);
    }

    /**
     * Get configuration.
     *
     * @return ConfigurationInterface
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Set configuration.
     *
     * We have to ensure that the configuration provided is NOT the active copy
     * of a configuration. This is so we can serialize, and unserialize properly.
     *
     * @param ConfigurationInterface $configuration
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        if ($configuration instanceof ActiveConfigurationInterface) {
            $configuration = $configuration->getOriginalConfig();
        }

        $this->configuration = $configuration;
    }

    /**
     * Get dataset data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set dataset data.
     *
     * @param array $data
     */
    public function setData(array $data)
    {
        if (!empty($this->data)) {
            throw new InvalidArgumentException("Data may not be reset in a base dataset.");
        }

        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }
}
