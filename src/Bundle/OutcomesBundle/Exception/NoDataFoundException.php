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

use LogicException;

/**
 * No data found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class NoDataFoundException extends LogicException implements OutcomesException
{
    /**
     * Exception constructor.
     */
    public function __construct()
    {
        $this->message = "No data was found in dataset.";
    }
}
