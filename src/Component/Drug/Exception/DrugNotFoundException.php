<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Drug\Exception;

use RuntimeException;

/**
 * Drug not found exception.
 *  
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DrugNotFoundException extends RuntimeException implements DrugException
{
    /**
     * Exception constructor.
     *
     * @param string $field
     * @param string|null $value
     */
    public function __construct($field, $value = null)
    {
        if (is_numeric($field)) {
            $this->message = sprintf('Drug with id "%d" cound not be found.', intval($field));
        } elseif (null === $value) {
            $this->message = sprintf('Drug count not be found in this %s.', strval($field));
        } else {
            $this->message = sprintf('Drug could not be found using %s with value %s', $field, strval($value));
        }
    }
}
