<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Exception;

use InvalidArgumentException;

/**
 * Invalid resource type exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResourceInvalidTypeException extends InvalidArgumentException
{
    /**
     * Exception constructor.
     *
     * @param mixed $givenType
     */
    public function __construct($givenType)
    {
        $this->message = sprintf(
            'Resource type must be one of ["0" for subject, "1" for target], %d given.',
            $givenType
        );
    }
}
