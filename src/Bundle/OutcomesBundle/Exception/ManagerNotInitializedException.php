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
 * Manager not initialized exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ManagerNotInitializedException extends LogicException implements OutcomesBundle
{
    /**
     * Exception constructor.
     */
    public function __construct()
    {
        $this->message = "The outcomes manager has not been properly initialized.";
    }
}
