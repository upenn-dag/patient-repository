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

use Countable;
use IteratorAggregate;

/**
 * Dataset interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface DatasetInterface extends IteratorAggregate, Countable
{
    /**
     * Get configuration.
     *
     * @return ConfigurationInterface
     */
    public function getConfiguration();

    /**
     * Get dataset data.
     *
     * @return array
     */
    public function getData();
}
