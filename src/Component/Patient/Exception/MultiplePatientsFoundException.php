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

use Exception;
use RuntimeException;

/**
 * Multiple patients found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class MultiplePatientsFoundException extends RuntimeException implements PatientException
{
    /**
     * Exception constructor.
     */
    public function __construct()
    {
        $this->message = 'Multiple patients have been found matching your search criteria, '
                       . 'but you requested a single result. Please narrow your search '
                       . 'so that it may only return one possible result or none.';
    }
}
