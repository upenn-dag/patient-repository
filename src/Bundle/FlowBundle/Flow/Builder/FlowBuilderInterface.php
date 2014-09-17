<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Flow\Builder;

use Accard\Bundle\FlowBundle\Flow\FlowInterface;
use Accard\Bundle\FlowBundle\Flow\Step\StepInterface;
use Accard\Bundle\FlowBundle\Flow\Scenario\FlowScenarioInterface;
use Accard\Bundle\FlowBundle\Exception\StepAccessException;
use Accard\Bundle\FlowBundle\Exception\DuplicateStepException;

/**
 * Flow builder.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FlowBuilderInterface
{
    /**
     * Build flow.
     *
     * @param FlowScenarioInterface $scenario
     */
    public function build(FlowScenarioInterface $scenario);

    /**
     * Get flow step.
     *
     * @throws StepAccessException When step has not been registered.
     * @param string $name
     * @return StepInterface
     */
    public function get($name);

    /**
     * Test for flow step presence.
     *
     * @param string $name
     * @return boolean
     */
    public function has($name);

    /**
     * Add flow step.
     *
     * @throws DuplicateStepException When step is already registered.
     * @param StepInterface|string $step
     */
    public function add($step);

    /**
     * Remove flow step.
     *
     * @throws StepAccessException When step has not been registered.
     * @param string $name
     */
    public function remove($name);
}
