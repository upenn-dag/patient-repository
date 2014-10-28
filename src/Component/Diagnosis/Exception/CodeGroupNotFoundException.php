<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Diagnosis\Exception;

use RuntimeException;

/**
 * Diagnosis code group not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeGroupNotFoundException extends RuntimeException implements DiagnosisException
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
            $this->message = sprintf('Diagnosis code group with id "%d" cound not be found.', intval($field));
        } elseif (null === $value) {
            $this->message = sprintf('Diagnosis code group count not be found in this %s.', strval($field));
        } else {
            $this->message = sprintf('Diagnosis code group could not be found using %s with value %s', $field, strval($value));
        }
    }
}
