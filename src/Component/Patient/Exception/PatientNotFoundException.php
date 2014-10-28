<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Patient\Exception;

use RuntimeException;

/**
 * Patient not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientNotFoundException extends RuntimeException implements PatientException
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
            $this->message = sprintf('Patient with id "%d" cound not be found.', $field);
        } elseif (null === $value) {
            $this->message = sprintf('Patient count not be found in this %s.', $field);
        } else {
            $this->message = sprintf('Patient could not be found using %s with value %s', $field, strval($value));
        }
    }
}
