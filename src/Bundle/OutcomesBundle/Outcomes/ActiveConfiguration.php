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

use InvalidArgumentException;
use Accard\Bundle\CoreBundle\State\StateInstance;
use Accard\Bundle\CoreBundle\Exception\StateException;
use Accard\Bundle\OutcomesBundle\Exception\FieldNotFoundException;
use Accard\Bundle\OutcomesBundle\Exception\TargetNotFoundException;
use Accard\Bundle\OutcomesBundle\Exception\TargetPrototypeNotFoundException;


/**
 * Outcomes configuration.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActiveConfiguration implements ActiveConfigurationInterface
{
    /**
     * Parent configuration.
     *
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * State instance.
     *
     * @var StateInstance
     */
    private $state;


    /**
     * Constructor.
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration, StateInstance $state)
    {
        $this->configuration = $configuration;
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalConfig()
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget()
    {
        $parentTarget = $this->configuration->getTarget();
        if (!$this->state->hasObject($parentTarget)) {
            throw new TargetNotFoundException($parentTarget);
        }

        return $this->state->getObject($parentTarget);
    }

    /**
     * {@inheritdoc}
     */
    public function getTargetPrototype()
    {
        if (null === ($parentTargetPrototype = $this->configuration->getTargetPrototype())) {
            return;
        }

        $target = $this->getTarget();

        if (!$target->hasPrototype($parentTargetPrototype)) {
            throw new TargetPrototypeNotFoundException($parentTargetPrototype);
        }

        return $target->getPrototype($parentTargetPrototype);
    }

    /**
     * {@inheritdoc}
     */
    public function getActualTarget()
    {
        if ($target = $this->getTargetPrototype()) {
            return $target;
        }

        return $this->getTarget();
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        $parentFilters = $this->configuration->getFilters();

        // This will be a little complex in terms of actually setting up a list of active filters...
    }

    /**
     * {@inheritdoc}
     */
    public function getFilteredFields()
    {
        $parentFilteredFields = $this->configuration->getFilteredFields();
        $target = $this->getResolvedTarget();
        $fields = array();

        foreach ($parentFilteredFields as $field) {
            if (!$target->hasField($field)) {
                throw new FieldNotFoundException($field);
            }

            $fields[$field] = $target->getField($field);
        }

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFilter($field)
    {
        return $this->configuration->hasFilter($field);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilter($field)
    {
        $parentFilter = $this->configuration->getFilter($field);
    }
}
