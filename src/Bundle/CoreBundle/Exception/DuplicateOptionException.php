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
 * State option exists exception.
 *
 * Thrown when a state option already exists.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DuplicateOptionException extends InvalidArgumentException implements StateException
{
    /**
     * Exception constructor.
     *
     * @param string $option
     */
    public function __construct($option)
    {
        $this->message = sprintf("State option '%s' already exists.", $option);
    }
}
