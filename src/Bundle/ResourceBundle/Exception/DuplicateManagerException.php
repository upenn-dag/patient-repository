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

/**
 * Duplicate importer manager exception.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DuplicateManagerException extends RuntimeException
{
    /**
     * Exception constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->message = sprintf('An manager with the name "%s" has already been registered.', $name);
    }
}
