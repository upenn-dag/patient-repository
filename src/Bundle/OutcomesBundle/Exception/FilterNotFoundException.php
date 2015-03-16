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
 * Filter not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FilterNotFoundException extends InvalidArgumentException implements OutcomesException
{
    /**
     * Exception constructor.
     *
     * @param string $filterName
     */
    public function __construct($filterName)
    {
        $this->message = sprintf('The filter "%s" can not be found.', $filterName);
    }
}
