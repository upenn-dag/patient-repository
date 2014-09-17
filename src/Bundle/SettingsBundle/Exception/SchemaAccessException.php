<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SettingsBundle\Exception;

use RuntimeException;

/**
 * Schema already registered exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SchemaAccessException extends RuntimeException
{
    /**
     * Exception constructor.
     *
     * @param string $namespace
     */
    public function __construct($namespace)
    {
        $this->message = sprintf('No schema registered with namespace "%s"', $namespace);
    }
}
