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
 * Behavior builder interface.
 *
 * Used to ease the programatic creation of behaviors.
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
}
