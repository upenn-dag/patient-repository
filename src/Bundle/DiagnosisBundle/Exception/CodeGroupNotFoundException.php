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
 * Diagnosis code group not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeGroupNotFoundException extends RuntimeException
{
    /**
     * Exception constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->message = sprintf("Unable to locate diagnosis code group named '%s'.", $name);
    }
}
