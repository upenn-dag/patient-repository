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
 * Duplicate step exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DuplicateStepException extends StepException
{
    /**
     * Exception constructor.
     *
     * @param string $stepAlias
     */
    public function __construct($stepAlias)
    {
        $this->message = sprintf('A step named "%s" has already been registered.', $stepAlias);
    }
}
