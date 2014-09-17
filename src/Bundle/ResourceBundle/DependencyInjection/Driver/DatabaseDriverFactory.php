<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Accard\Bundle\ResourceBundle\DependencyInjection\Driver;

use Accard\Bundle\ResourceBundle\Exception\Driver\UnknownDriverException;
use Accard\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DatabaseDriverFactory
{
    public static function get(
        $type = AccardResourceBundle::DRIVER_DOCTRINE_ORM,
        ContainerBuilder $container,
        $prefix,
        $resourceName,
        $templates = null
    ) {
        switch ($type) {
            case AccardResourceBundle::DRIVER_DOCTRINE_ORM:
                return new DoctrineORMDriver($container, $prefix, $resourceName, $templates);
            default:
                throw new UnknownDriverException($type);
        }
    }
}
