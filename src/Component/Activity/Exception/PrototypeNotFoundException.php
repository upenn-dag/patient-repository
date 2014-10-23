<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Exception;

use InvalidArgumentException;

/**
 * Activity prototype not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PrototypeNotFoundException extends InvalidArgumentException
{
    /**
     * Exception constructor.
     *
     * @param string|integer $prototype
     */
    public function __construct($prototype)
    {
        if (is_integer($prototype)) {
            $this->message = sprintf('Activity prototype with id "%d" can not be found.', $prototype);
        } else {
            $this->message = sprintf('Activity prototype with name "%s" can not be found.', $prototype);
        }
    }
}
