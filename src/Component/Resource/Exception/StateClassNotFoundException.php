<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Exception;

use InvalidArgumentException;

/**
 * State class not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class StateClassNotFoundException extends InvalidArgumentException implements StateException
{
    /**
     * Exception constructor.
     *
     * @param string $class
     */
    public function __construct($class)
    {
        $this->message = sprintf('State class "%s" could not be found.', $class);
    }
}
