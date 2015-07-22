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

use DAG\Component\Resource\Builder\BuilderInterface;

/**
 * Attribute Builder.
 *
 * Used to ease the programmatic creation of attributes.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface AttributeBuilderInterface extends BuilderInterface
{
    /**
     * Create a new attribute.
     *
     * @return AttributeBuilderInterface
     */
    public function create();

    /**
     * Add field with name and value.
     *
     * @param string $name
     * @param mixed $value
     * @param string|null $presentation
     * @return AttributeBuilderInterface
     */
    public function addField($name, $value, $presentation = null);
}
