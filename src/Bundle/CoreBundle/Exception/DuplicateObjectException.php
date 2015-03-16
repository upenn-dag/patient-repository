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
 * State object exists exception.
 *
 * Thrown when a state object already exists.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DuplicateObjectException extends InvalidArgumentException implements StateException
{
    /**
     * Exception constructor.
     *
     * @param string $object
     */
    public function __construct($object)
    {
        $this->message = sprintf("State object '%s' already exists.", $object);
    }
}
