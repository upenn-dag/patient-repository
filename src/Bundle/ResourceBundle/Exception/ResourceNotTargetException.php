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
 * Resource not target exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResourceNotTargetException extends RuntimeException
{
    public function __construct(ResourceInterface $target)
    {
        $this->message = sprintf('Object of class %s must be registered as a target.', get_class($target));
    }
}
