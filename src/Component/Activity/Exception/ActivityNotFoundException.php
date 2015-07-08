<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Exception;

use InvalidArgumentException;

/**
 * Activity not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityNotFoundException extends InvalidArgumentException implements ActivityException
{
    /**
     * Exception constructor.
     *
     * @param integer $activity
     */
    public function __construct($activity)
    {
        $this->message = sprintf('Activity with id "%d" can not be found.', $activity);
    }
}
