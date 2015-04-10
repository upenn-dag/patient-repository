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
 * Target prototype not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TargetPrototypeNotFoundException extends InvalidArgumentException implements OutcomesException
{
    /**
     * Exception constructor.
     *
     * @param string $targetName
     * @param string $prototypeName
     */
    public function __construct($targetName, $prototypeName)
    {
        $this->message = sprintf('The prototype "%s" can not be found on target "%s".', $prototypeName, $targetName);
    }
}
