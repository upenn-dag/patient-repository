<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PatientBundle\Exception;

use RuntimeException;

/**
 * Patient not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientNotFoundException extends RuntimeException
{
    /**
     * Exception constructor.
     *
     * @param string $field
     * @param string $value
     */
    public function __construct($field, $value)
    {
        $this->message = sprintf('Patient could not be found using %s with value %s', $field, strval($value));
    }
}
