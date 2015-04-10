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
 * Trans dataset.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TransDataset implements DatasetInterface
{
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
     * @param ConfigurationInterface $configuration
     * @param array $data
     */
    public function __construct(ConfigurationInterface $configuration, array $data = array())
    {
        $this->setConfiguration($configuration);
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
            throw new InvalidArgumentException("Data may not be reset in a translated dataset.");
        }

        foreach ($data as $key => $datum) {
            if (!is_array($datum)) {
                throw new InvalidArgumentException("Invalid data supplied for translated dataset.");
            }

            $data[$key] = new TransDatasetRecord($datum);
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
