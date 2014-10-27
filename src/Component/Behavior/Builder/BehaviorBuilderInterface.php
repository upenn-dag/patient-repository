<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Behavior\Builder;

use Accard\Component\Resource\Builder\BuilderInterface;

/**
 * Behavior Builder.
 *
 * Used to ease the programmatic creation of behaviors.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface BehaviorBuilderInterface extends BuilderInterface
{
    /**
     * Create a new behavior.
     *
     * @return BehaviorBuilderInterface
     */
    public function create();

    /**
     * Add field with name and value.
     *
     * @param string $name
     * @param mixed $value
     * @param string|null $presentation
     * @return BehaviorBuilderInterface
     */
    public function addField($name, $value, $presentation = null);
}
