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

/**
 * Outcomes filter configuration.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FilterConfiguration
{
    /**
     * Filter name.
     * 
     * @var string
     */
    protected $filterName;

    /**
     * Filter options.
     * 
     * @var array
     */
    protected $options;


    /**
     * Constructor.
     * 
     * @param string $filterName
     * @param array $options
     */
    public function __construct($filterName, array $options = array())
    {
        $this->filterName = $filterName;
        $this->options = $options;
    }

    /**
     * Get filter name.
     * 
     * @return string
     */
    public function getFilterName()
    {
        return $this->filterName;
    }

    /**
     * Get filter options.
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Test for presence of a filter option.
     * 
     * @param string $optionName
     * @return boolean
     */
    public function hasOption($optionName)
    {
        return isset($this->options[$optionName]);
    }

    /**
     * Get a filter option by name.
     * 
     * @param string $optionName
     * @return mixed
     */
    public function getOption($optionName)
    {
        if (!$this->hasOption($optionName)) {
            throw new InvalidArgumentException(sprintf("The option '%s' can not be found.", $optionName));
        }

        return $this->options[$optionName];
    }

    /**
     * Set a filter option by name.
     * 
     * @param string $optionName
     * @param mixed $optionValue
     * @return self
     */
    public function setOption($optionName, $optionValue = null)
    {
        $this->options[$optionName] = $optionValue;

        return $this;
    }
}
