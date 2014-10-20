<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Builder;

use Accard\Component\Resource\Builder\BuilderInterface;

/**
 * Activity Builder.
 *
 * Used to ease the programmatic creation of samples.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ActivityBuilderInterface extends BuilderInterface
{
    /**
     * Create a new sample.
     *
     * @return ActivityBuilderInterface
     */
    public function create();

    /**
     * Add field with name and value.
     *
     * @param string $name
     * @param mixed $value
     * @param string|null $presentation
     * @return ActivityBuilderInterface
     */
    public function addField($name, $value, $presentation = null);
}
