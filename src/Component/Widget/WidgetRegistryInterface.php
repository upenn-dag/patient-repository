<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Widget;

use Accard\Component\Widget\Exception\UnexpectedTypeException;
use Accard\Component\Widget\Exception\InvalidArgumentException;

/**
 * Widget registry interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetRegistryInterface
{
    /**
     * Get widget type by name.
     *
     * @throws UnexpectedTypeException If name is not a string.
     * @throws InvalidArgumentException If type can not be found.
     * @param string $name
     * @return ResolvedWidgetTypeInterface
     */
    public function getType($name);

    /**
     * Test for presence of a widget type.
     *
     * @param string $name
     * @return boolean
     */
    public function hasType($name);

    /**
     * Get extensions.
     *
     * @return WidgetExtensionInterface[]
     */
    public function getExtensions();
}
