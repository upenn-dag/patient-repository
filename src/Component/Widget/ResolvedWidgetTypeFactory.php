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

/**
 * Resolved widget type factory.
 *
 * Creates ResolvedWidgetTypeInterface instances.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResolvedWidgetTypeFactory implements ResolvedWidgetTypeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createResolvedType(WidgetTypeInterface $type, ResolvedWidgetTypeInterface $parent = null)
    {
        return new ResolvedWidgetType($type, $parent);
    }
}
