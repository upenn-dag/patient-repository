<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Phase\Exception;

use RuntimeException;

/**
 * Phase not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PhaseNotFoundException extends RuntimeException
{
    /**
     * Exception constructor.
     *
     * @param string $label
     */
    public function __construct($label)
    {
        $this->message = sprintf('Phase with label "%s" not found.', $label);
    }
}
