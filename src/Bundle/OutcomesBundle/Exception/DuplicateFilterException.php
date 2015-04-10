<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Exception;

use InvalidArgumentException;

/**
 * Duplicate filter exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DuplicateFilterException extends InvalidArgumentException implements OutcomesException
{
    /**
     * Exception constructor.
     *
     * @param string $filterName
     */
    public function __construct($filterName)
    {
        $this->message = sprintf('The filter "%s" already exists, and may not be reset.', $filterName);
    }
}
