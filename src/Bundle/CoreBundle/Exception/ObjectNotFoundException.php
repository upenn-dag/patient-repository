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
 * State object not found exception.
 *
 * Thrown when an object can not be found.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ObjectNotFoundException extends InvalidArgumentException implements StateException
{
    /**
     * Exception constructor.
     *
     * @param string $object
     */
    public function __construct($object)
    {
        $this->message = sprintf("State object '%s' can not be found.", $object);
    }
}
