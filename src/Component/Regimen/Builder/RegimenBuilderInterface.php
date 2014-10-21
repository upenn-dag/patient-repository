<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Regimen\Builder;

use Accard\Component\Resource\Builder\BuilderInterface;

/**
 * Regimen Builder.
 *
 * Used to ease the programmatic creation of regimens.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface RegimenBuilderInterface extends BuilderInterface
{
    /**
     * Create a new regimen.
     *
     * @return RegimenBuilderInterface
     */
    public function create();

    /**
     * Add field with name and value.
     *
     * @param string $name
     * @param mixed $value
     * @param string|null $presentation
     * @return RegimenBuilderInterface
     */
    public function addField($name, $value, $presentation = null);
}
