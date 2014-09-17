<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Flow\Step;

use Accard\Bundle\FlowBundle\Flow\Step\StepInterface;
use Accard\Bundle\FlowBundle\Exception\DuplicateStepException;
use Accard\Bundle\FlowBundle\Exception\DuplicateStepAliasException;
use Accard\Bundle\FlowBundle\Exception\StepAccessException;

/**
 * Step registry.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class StepRegistry
{
    /**
     * Step container.
     *
     * @var array|StepInterface[]
     */
    private $steps;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->steps = array();
    }

    /**
     * Test for presence of alias.
     *
     * @param string $alias
     * @return boolean
     */
    public function has($alias)
    {
        return isset($this->steps[$alias]);
    }

    /**
     * Get step by alias.
     *
     * @param string $alias
     * @return StepInterface
     */
    public function get($alias)
    {
        if (!$this->has($alias)) {
            throw new StepAccessException($alias);
        }

        return $this->steps[$alias];
    }

    /**
     * Register step.
     *
     * @param string $alias
     * @param StepInterface $step
     */
    public function register($alias, StepInterface $step)
    {
        if ($this->has($alias)) {
            throw new DuplicateStepAliasException($alias);
        }

        $this->steps[$alias] = $step;
    }

    /**
     * Unregister step.
     *
     * @param StepInterface $step
     */
    public function unregister(StepInterface $step)
    {
        if (!$this->has($step)) {
            throw new StepAccessException($step);
        }

        $index = array_search($step, $this->steps);
        unset($this->steps[$index]);
    }

    /**
     * Unregister step by alias.
     *
     * @param string $alias
     */
    public function unregisterAlias($alias)
    {
        if (!$this->has($alias)) {
            throw new StepAccessException($alias);
        }

        unset($this->steps[$alias]);
    }
}
