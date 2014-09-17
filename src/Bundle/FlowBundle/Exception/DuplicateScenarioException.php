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

use InvalidArgumentException;

/**
 * Duplicate scenario exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DuplicateScenarioException extends InvalidArgumentException
{
    /**
     * Exception constructor.
     *
     * @param string $alias
     * @param FlowScenarioInterface $scenario
     */
    public function __construct($alias, FlowScenarioInterface $scenario)
    {
        $this->message = sprintf('A scenario with alias "%s" has already been registered.', $alias);
    }
}
