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

/**
 * Duplicate step alias exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DuplicateStepAliasException extends StepException
{
    /**
     * Exception constructor.
     *
     * @param string $alias
     */
    public function __construct($alias)
    {
        $this->message = sprintf('A step with alias "%s" has already been registered.', $alias);
    }
}
