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

use RuntimeException;
use Accard\Bundle\ResourceBundle\Import\ResourceInterface;

/**
 * Resource not subject exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResourceNotSubjectException extends RuntimeException
{
    public function __construct(ResourceInterface $subject)
    {
        $this->message = sprintf('Object of class %s must be registered as a subject.', get_class($subject));
    }
}
