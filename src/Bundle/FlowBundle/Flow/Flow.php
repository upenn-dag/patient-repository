<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Flow;

use Accard\Bundle\FlowBundle\Flow\Step\StepInterface;
use Accard\Bundle\FlowBundle\Exception\StepAccessException;
use Accard\Bundle\FlowBundle\Exception\DuplicateStepException;
use Accard\Bundle\FlowBundle\Exception\DuplicateStepAliasException;

/**
 * Flow.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Flow implements FlowInterface
{
    /**
     * Scenario alias.
     *
     * @var string
     */
    protected $scenarioAlias;

    /**
     * Flow steps.
     *
     * @var array|StepInterface[]
     */
    protected $steps = array();

    /**
     * Ordered steps.
     *
     * @var array|StepInterface[]
     */
    private $orderedSteps = array();

    /**
     * Display route.
     *
     * @var string
     */
    protected $displayRoute;

    /**
     * Start route.
     *
     * @var string
     */
    protected $startRoute;

    /**
     * Forward route.
     *
     * @var string
     */
    protected $forwardRoute;

    /**
     * Redirect route.
     *
     * @var string
     */
    protected $redirectRoute;

    /**
     * Redirect route parameters.
     *
     * @var array
     */
    protected $redirectParams = array();

    /**
     * Save callback.
     *
     * @var callable
     */
    protected $saveCallback;



    /**
     * Set scenario alias.
     *
     * @param string $scenarioAlias
     */
    public function setScenarioAlias($scenarioAlias)
    {
        $this->scenarioAlias = $scenarioAlias;
    }

    /**
     * Get scenario alias.
     *
     * @return string
     */
    public function getScenarioAlias()
    {
        return $this->scenarioAlias;
    }

    /**
     * {@inheritdoc}
     */
    public function setDisplayRoute($displayRoute)
    {
        $this->displayRoute = $displayRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayRoute()
    {
        return $this->displayRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartRoute($startRoute)
    {
        $this->startRoute = $startRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartRoute()
    {
        return $this->startRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function setForwardRoute($forwardRoute)
    {
        $this->forwardRoute = $forwardRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function getForwardRoute()
    {
        return $this->forwardRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function setRedirectRoute($redirectRoute)
    {
        $this->redirectRoute = $redirectRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectRoute()
    {
        return $this->redirectRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function setRedirectParams(array $params)
    {
        $this->redirectParams = $params;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectParams()
    {
        return $this->redirectParams;
    }

    /**
     * {@inheritdoc}
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderedSteps()
    {
        return $this->orderedSteps;
    }

    /**
     * {@inheritdoc}
     */
    public function countSteps()
    {
        return count($this->steps);
    }

    /**
     * {@inheritdoc}
     */
    public function getStep($alias)
    {
        if (!$this->hasStep($alias)) {
            throw new StepAccessException($alias);
        }

        return $this->steps[$alias];
    }

    /**
     * {@inheritdoc}
     */
    public function getStepByIndex($index)
    {
        if (!isset($this->orderedSteps[$index])) {
            throw new StepAccessException($index);
        }

        return $this->orderedSteps[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstStep()
    {
        try {
            return $this->getStepByIndex(0);
        } catch (StepAccessException $e) {}
    }

    /**
     * {@inheritdoc}
     */
    public function getLastStep()
    {
        try {
            return $this->getStepByIndex($this->countSteps() - 1);
        } catch (StepAccessException $e) {}
    }

    /**
     * {@inheritdoc}
     */
    public function hasStep($alias)
    {
        return isset($this->steps[$alias]);
    }

    /**
     * {@inheritdoc}
     */
    public function addSteps(array $steps)
    {
        foreach ($steps as $alias => $step) {
            $this->addStep($alias, $step);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addStep($alias, StepInterface $step, array $options = array())
    {
        if ($this->hasStep($alias)) {
            throw new DuplicateStepAliasException($alias);
        }

        if (method_exists($step, 'setName')) {
            $step->setName($alias);
        }

        $step->setOptions($options);
        $this->steps[$alias] = $this->orderedSteps[] = $step;
    }

    /**
     * {@inheritdoc}
     */
    public function removeStep(StepInterface $step)
    {
        if (!$this->hasStep($step)) {
            throw new StepAccessException($step);
        }

        $index = array_search($step, $this->steps);
        $orderedIndex = array_search($step, $this->orderedSteps);
        unset($this->steps[$index], $this->orderedSteps[$orderedIndex]);
    }

    /**
     * {@inheritdoc}
     */
    public function removeStepByAlias($alias)
    {
        if (!$this->hasStepAlias($alias)) {
            throw new StepAccessException($alias);
        }

        $index = array_search($this->steps[$alias], $this->orderedSteps);
        unset($this->steps[$alias]);
        unset($this->orderedSteps[$index]);
    }

    /**
     * {@inheritdoc}
     */
     public function setSaveCallback(callable $callback)
     {
        $this->saveCallback = $callback;
     }

     /**
     * {@inheritdoc}
     */
     public function getSaveCallback()
     {
        return $this->saveCallback;
     }
}
