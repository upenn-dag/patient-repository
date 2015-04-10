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

/**
 * Outcomes active configuration.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ActiveConfigurationInterface extends ConfigurationInterface
{
    /**
     * Get original configuration object.
     *
     * @return ConfigurationInterface
     */
    public function getOriginalConfig();

    /**
     * Get target or target prototype based on configuration.
     *
     * @return ...
     */
    public function getActualTarget();
}
