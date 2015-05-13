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
 * Manager access exception.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class ManagerAccessException extends RuntimeException
{
    /**
     * Exception constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->message = sprintf('No manager with the name "%s" has been registered.', $name);
    }
}
