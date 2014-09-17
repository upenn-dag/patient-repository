<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Exception;

use LogicException;

/**
 * Flow not initialized exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FlowNotInitializedException extends LogicException
{
    /**
     * Exception constructor.
     */
    public function __construct()
    {
        $this->message = 'Flow must be initialized before builder methods may be used.';
    }
}
