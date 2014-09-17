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

use Accard\Bundle\FlowBundle\Flow\Step\StepInterface;

/**
 * Step access exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class StepAccessException extends StepException
{
    /**
     * Exception constructor.
     *
     * @param StepInterface|string|integer $step
     */
    public function __construct($step)
    {
        if (is_numeric($step)) {
            $this->message = sprintf('No step exists at index %d.', $step);
        } elseif ($step instanceof StepInterface) {
            $this->message = sprintf('Step with class "%s" could not be found.', get_class($step));
        } else {
            $this->message = sprintf('No step named "%s" has been registered.', $step);
        }
    }
}
