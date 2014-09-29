<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Prototype\Exception;

use InvalidArgumentException;

/**
 * Prototype not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PrototypeNotFoundException extends InvalidArgumentException
{
    /**
     * Exception constructor.
     *
     * @param string $prototype
     */
    public function __construct($prototype)
    {
        if (is_integer($prototype)) {
            $this->message = sprintf('Prototype with id "%d" could not be found.', $prototype);
        } else {
            $this->message = sprintf('Prototype named "%s" could not be found.', $prototype);
        }
    }
}
