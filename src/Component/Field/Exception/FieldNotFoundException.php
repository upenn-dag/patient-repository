<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Field\Exception;

use InvalidArgumentException;

/**
 * Field not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldNotFoundException extends InvalidArgumentException
{
    /**
     * Exception constructor.
     *
     * @param string $field
     */
    public function __construct($field)
    {
        if (is_integer($field)) {
            $this->message = sprintf('Field with id "%d" could not be found.', $field);
        } else {
            $this->message = sprintf('Field named "%s" could not be found.', $field);
        }
    }
}
