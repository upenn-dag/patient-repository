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
     * Filter registry.
     *
     * @var FilterRegistry
     */
    private $filterRegistry;


    /**
     * Constructor.
     *
     * @param Configuration $configuration
     * @param StateInstance $state
     * @param FilterRegistry $filterRegistry
     */
    public function __construct(Configuration $configuration,
                                StateInstance $state,
                                FilterRegistry $filterRegistry)
    {
        $this->configuration = $configuration;
        $this->state = $state;
        $this->filterRegistry = $filterRegistry;
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
    public function getFields()
    {
        $target = $this->getActualTarget();
        $parentFilters = $this->configuration->getFields();
        $output = array();

        foreach ($parentFilters as $field => $filters) {
            if (!$target->hasField($field)) {
                throw new FieldNotFoundException($field);
            }

            $output[$field] = array();

            foreach ($filters as $filter) {
                if (!$this->filterRegistry->hasFilter($filter->getFilterName())) {
                    throw new \Exception(sprintf('The filter "%s" has not been registered.', $filter->getFilterName()));
                }

                $output[$field][] = $this->filterRegistry->getFilter($filter->getFilterName());
            }
        }

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilteredFields()
    {
        $parentFilteredFields = $this->configuration->getFilteredFields();
        $target = $this->getActualTarget();
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
    public function hasField($field)
    {
        return $this->configuration->hasField($field);
    }

    /**
     * {@inheritdoc}
     */
    public function getField($field)
    {
        return $this->getTarget()->getField($field);
        $parentFilter = $this->configuration->getField($field);
    }
}
