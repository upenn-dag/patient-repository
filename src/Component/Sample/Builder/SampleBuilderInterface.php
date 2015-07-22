<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Sample\Builder;

use DAG\Component\Resource\Builder\BuilderInterface;

/**
 * Sample Builder.
 *
 * Used to ease the programmatic creation of samples.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SampleBuilderInterface extends BuilderInterface
{
    /**
     * Create a new sample.
     *
     * @return SampleBuilderInterface
     */
    public function create();

    /**
     * Add field with name and value.
     *
     * @param string $name
     * @param mixed $value
     * @param string|null $presentation
     * @return SampleBuilderInterface
     */
    public function addField($name, $value, $presentation = null);
}
