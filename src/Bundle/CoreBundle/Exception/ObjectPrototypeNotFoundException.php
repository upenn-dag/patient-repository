<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Exception;

use InvalidArgumentException;

/**
 * State object prototype not found exception.
 *
 * Thrown when an object prototype can not be found.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ObjectPrototypeNotFoundException extends InvalidArgumentException implements StateException
{
    /**
     * Exception constructor.
     *
     * @param string $objectName
     * @param string $prototypeName
     */
    public function __construct($objectName, $prototypeName)
    {
        $this->message = sprintf("State object '%s' has no prototype '%s'.", $objectName, $prototypeName);
    }
}
