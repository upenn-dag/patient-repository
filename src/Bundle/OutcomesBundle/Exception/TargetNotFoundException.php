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
 * Target not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TargetNotFoundException extends InvalidArgumentException implements OutcomesException
{
    /**
     * Exception constructor.
     *
     * @param string $targetName
     */
    public function __construct($targetName)
    {
        $this->message = sprintf('The target "%s" can not be found.', $targetName);
    }
}
