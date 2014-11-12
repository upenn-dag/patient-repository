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
 * Resolved widget type factory.
 *
 * Creates ResolvedWidgetTypeInterface instances.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ResolvedWidgetTypeFactoryInterface
{
    /**
     * Resolve a widget type.
     *
     * @throws UnexpectedTypeException If the parent is not a string.
     * @throws InvalidArgumentException If the parent can not be retrieved.
     * @param WidgetTypeInterface $type
     * @param ResolvedWidgetTypeInterface|null $parent
     * @return ResolvedWidgetTypeInterface
     */
}
