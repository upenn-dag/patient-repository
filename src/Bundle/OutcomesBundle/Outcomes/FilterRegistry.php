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

use Accard\Bundle\OutcomesBundle\Outcomes\Filter\FilterInterface;
use Accard\Bundle\OutcomesBundle\Exception\FilterNotFoundException;
use Accard\Bundle\OutcomesBundle\Exception\DuplicateFilterException;

/**
 * Filter registry.
 *
 * Currently, this filter registry is NOT dynamic. We probably shoud allow for
 * extending the list of available filter types and what not, but for now, it
 * simply assigns a static list of filters available.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FilterRegistry
{
    /**
     * Filters list.
     *
     * @var FilterInterface[]
     */
    private $filters;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->filters = array();
        $this->addFilter(new Filter\DateBetweenFilter());
        $this->addFilter(new Filter\EmptyFilter());
        $this->addFilter(new Filter\NotEmptyFilter());
    }

    /**
     * Get all filters.
     *
     * @return FilterInterface[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Test for presence of a filter.
     *
     * @param FilterInterface|string $filterName
     * @return boolean
     */
    public function hasFilter($filterName)
    {
        if ($filterName instanceof FilterInterface) {
            $filterName = $filterName->getName();
        }

        return isset($this->filters[$filterName]);
    }

    /**
     * Get filter by name.
     *
     * @throws FilterNotFoundException If filter can not be found by name.
     * @param string $filterName
     * @return FilterInterface
     */
    public function getFilter($filterName)
    {
        if (!$this->hasFilter($filterName)) {
            throw new FilterNotFoundException($filterName);
        }

        return $this->filters[$filterName];
    }

    /**
     * Add filter.
     *
     * @throws DuplicateFilterException If filter name is re-used.
     * @param FilterInterface $filter
     * @return self
     */
    public function addFilter(FilterInterface $filter)
    {
        if ($this->hasFilter($filter)) {
            throw new DuplicateFilterException($filter->getName());
        }

        $this->filters[$filter->getName()] = $filter;

        return $this;
    }

    /**
     * Remove filter.
     *
     * @throws BadMethodCallException All the time, for now.
     * @param FilterInterface $filter
     * @return self
     */
    public function removeFilter(FilterInterface $filter)
    {
        throw new \BadMethodCallException("Not supported.");
    }
}
