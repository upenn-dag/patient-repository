<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Option\Exception;

use InvalidArgumentException;

/**
 * Option not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionNotFoundException extends InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param string $optionName
     */
    public function __construct($optionName)
    {
        $this->message = sprintf('Unable to locate an option named "%s".', $optionName);
    }
}
