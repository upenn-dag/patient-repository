<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Attribute\Builder;

use Accard\Component\Resource\Builder\BuilderInterface;

/**
 * Attribute builder interface.
 *
 * Used to ease the programatic creation of attributess.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
interface AttributeBuilderInterface extends BuilderInterface
{
    /**
     * Create a new attributes.
     *
     * @return AttributeBuilderInterface
     */
    public function create();
}
