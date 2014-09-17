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
 * Scenario access exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ScenarioAccessException extends InvalidArgumentException
{
    /**
     * Exception constructor.
     *
     * @param string $scenarioAlias
     */
    public function __construct($scenarioAlias)
    {
        $this->message = sprintf('No scenario named "%s" has been registered.', $scenarioAlias);
    }
}
