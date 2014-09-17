<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle\Exception;

use RuntimeException;

/**
 * Diagnosis not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisNotFoundException extends RuntimeException
{
    /**
     * Exception constructor.
     *
     * @param integer $id
     */
    public function __construct($id)
    {
        $this->message = sprintf("Unable to locate a diagnosis with id '%d'.", $id);
    }
}
