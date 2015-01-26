<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Widget\Extension\Core;

use Accard\Component\Widget\AbstractExtension;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Core widget extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CoreExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadTypes()
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        return array(
            new Type\WidgetType($accessor),
            new Type\TextType(),
            new Type\HeadingType(),
            new Type\ResourceType($accessor),
            new Type\DateType(),
            new Type\NumberType(),
            new Type\StringType(),
            new Type\ScalarType(),
            new Type\GridType(),
        );
    }
}
