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
 * Duplicate importer exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DuplicateImporterException extends RuntimeException
{
    /**
     * Exception constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->message = sprintf('An importer with the name "%s" has already been registered.', $name);
    }
}
