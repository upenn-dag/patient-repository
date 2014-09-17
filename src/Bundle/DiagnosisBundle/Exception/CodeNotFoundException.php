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
 * Diagnosis code not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeNotFoundException extends RuntimeException
{
    /**
     * Exception constructor.
     *
     * @param string $codeString
     */
    public function __construct($codeString)
    {
        $this->message = sprintf("Unable to locate a diagnosis code '%s'.", $codeString);
    }
}
