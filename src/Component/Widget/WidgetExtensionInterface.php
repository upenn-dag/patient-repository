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

use Accard\Component\Widget\Exception\InvalidArgumentException;

/**
 * Widget extension interface.
 * 
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetExtensionInterface
{
    /**
     * Get widget type by name.
     *
     * @throws InvalidArgumentException If the given type is not supported by this extension.
     * @param string $name
     * @return WidgetTypeInterface
     */
    public function getType($name);

    /**
     * Test for presence of a widget type.
     *
     * @param string $name
     * @return boolean
     */
    public function hasType($name);
}
