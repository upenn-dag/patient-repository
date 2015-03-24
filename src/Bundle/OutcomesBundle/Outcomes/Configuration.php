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
use Accard\Bundle\OutcomesBundle\Exception\DuplicateFieldException;


/**
 * Outcomes configuration.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Target name.
     *
     * @var string
     */
    protected $target;

    /**
     * Target prototype name.
     *
     * @var string
     */
    protected $targetPrototype;

    /**
     * Target filters.
     *
     * @var array
     */
    protected $filters = array();

    /**
     * Target translations.
     *
     * @var array
     */
    protected $translations = array();


    /**
     * Set target object.
     *
     * @param string $target
     * @return self
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set target object prototype.
     *
     * @param string $targetPrototype
     * @return self
     */
    public function setTargetPrototype($targetPrototype)
    {
        $this->targetPrototype = $targetPrototype;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTargetPrototype()
    {
        return $this->targetPrototype;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFilter($field)
    {
        return isset($this->filters[$field]);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilter($field)
    {
        if (!$this->hasFilter($field)) {
            throw new FieldNotFoundException($field);
        }

        return $this->filters[$field];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilteredFields()
    {
        return array_keys($this->filters);
    }

    /**
     * Set all filters.
     *
     * @param FilterConfiguration[] $filters
     */
    public function setFilters(array $filters)
    {
        foreach ($filters as $field => $filter) {
            $this->addFilter($field, $filter);
        }

        return $this;
    }

    /**
     * Set filter for a given field.
     *
     * @param string $field
     * @param FilterConfiguration $filter
     * @return self
     */
    public function setFilter($field, FilterConfiguration $filter)
    {
        if ($this->hasFilter($field)) {
            throw new DuplicateFieldException($field);
        }

        $this->filters[$field] = $filter;

        return $this;
    }

    /**
     * Remove filter for a given field.
     *
     * @param string $field
     * @return self
     */
    public function removeFilter($field)
    {
        if (!$this->hasFilter($field)) {
            throw new FieldNotFoundException($field);
        }

        unset($this->filters[$field]);

        return $this;
    }

    /**
     * Get all translations.
     *
     * @return array
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Get all translation keys.
     *
     * @return array
     */
    public function getTranslationKeys()
    {
        return array_keys($this->translations);
    }

    /**
     * Set all translations.
     *
     * @param array $translations
     * @return self
     */
    public function setTranslations(array $translations)
    {
        $this->translations = $translations;

        return $this;
    }

    /**
     * Create a new filter configuration.
     *
     * @param string $filterName
     * @param array $filterOptions
     * @return FilterConfiguration
     */
    public function createFilterConfig($filterName, array $filterOptions = array())
    {
        return new FilterConfiguration($filterName, $filterOptions);
    }
}
