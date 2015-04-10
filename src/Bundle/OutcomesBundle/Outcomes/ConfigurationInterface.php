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

use Accard\Bundle\OutcomesBundle\Exception\FilterNotFoundException;

/**
 * Outcomes configuration.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ConfigurationInterface
{
    /**
     * Get target object.
     *
     * @return string
     */
    public function getTarget();

    /**
     * Get target object prototype.
     *
     * @return string
     */
    public function getTargetPrototype();

    /**
     * Get all fields.
     *
     * @return FilterConfigurationCollection[]
     */
    public function getFields();

    /**
     * Get list of filtered fields.
     *
     * @return string[]
     */
    public function getFilteredFields();

    /**
     * Test for presence of filter for a given field.
     *
     * @param string $field
     * @return boolean
     */
    public function hasField($field);

    /**
     * Get filter for a given field.
     *
     * @throws FilterNotFoundException When filter can not be located.
     * @param string $field
     * @return FilterConfiguration
     */
    public function getField($field);
}
