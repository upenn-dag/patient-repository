<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Flow\Context;

use Accard\Bundle\FlowBundle\Flow\FlowInterface;
use Accard\Bundle\FlowBundle\Flow\Step\StepInterface;
use Accard\Bundle\FlowBundle\Exception\ContextNotInitializedException;
use Accard\Bundle\FlowBundle\Exception\StepAccessException;
use Accard\Bundle\FlowBundle\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Flow context.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FlowContext implements FlowContextInterface
{
    /**
     * Flow.
     *
     * @var FlowInterface
     */
    protected $flow;

    /**
     * Current step.
     *
     * @var StepInterface
     */
    protected $currentStep;

    /**
     * Previous step.
     *
     * @var StepInterface|null
     */
    protected $previousStep;

    /**
     * Next step.
     *
     * @var StepInterface|null
     */
    protected $nextStep;

    /**
     * Context initialized?
     *
     * @var boolean
     */
    protected $initialized;

    /**
     * Flow progress.
     *
     * @var integer
     */
    protected $progress;

    /**
     * Flow storage.
     *
     * @param StorageInterface
     */
    protected $storage;

    /**
     * Request.
     *
     * @var Request
     */
    protected $request;


    /**
     * Constructor.
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
        $this->initialized = false;
        $this->progress = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(FlowInterface $flow, StepInterface $currentStep)
    {
        $steps = $flow->getOrderedSteps();
        $index = array_search($currentStep, $steps, true);

        $this->storage->initialize(md5($flow->getScenarioAlias()));

        $this->flow = $flow;
        $this->currentStep = $currentStep;
        $this->previousStep = isset($steps[$index - 1]) ? $steps[$index - 1] : null;
        $this->nextStep = isset($steps[$index + 1]) ? $steps[$index + 1] : null;
        $this->progress = $this->calculateProgress($index);
        $this->initialized = true;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->assertInitialized();
        $this->storage->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function getFlow()
    {
        $this->assertInitialized();

        return $this->flow;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentStep()
    {
        $this->assertInitialized();

        return $this->currentStep;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousStep()
    {
        $this->assertInitialized();

        return $this->previousStep;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextStep()
    {
        $this->assertInitialized();

        return $this->nextStep;
    }

    /**
     * {@inheritdoc}
     */
    public function isFirstStep()
    {
        $this->assertInitialized();

        return null === $this->previousStep;
    }

    /**
     * {@inheritdoc}
     */
    public function isLastStep()
    {
        $this->assertInitialized();

        return null === $this->nextStep;
    }

    /**
     * Get progress.
     *
     * @return integer
     */
    public function getProgress()
    {
        $this->assertInitialized();

        return $this->progress;
    }

    /**
     * Get storage.
     *
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set request.
     *
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get request.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function getStepHistory()
    {
        return $this->storage->get('history', array());
    }

    /**
     * {@inheritdoc}
     */
    public function setStepHistory(array $history)
    {
        $this->storage->set('history', $history);
    }

    /**
     * {@inheritdoc}
     */
    public function addStepToHistory($stepName)
    {
        $history = $this->getStepHistory();
        array_push($history, $stepName);
        $this->setStepHistory($history);
    }

    /**
     * {@inheritdoc}
     */
    public function getStepData($step = null)
    {
        $step = $step ?: $this->currentStep;

        if (is_string($step)) {
            $step = $this->flow->getStep($step);
        }

        return $this->storage->get($step->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function hasStepData($step = null)
    {
        $step = $step ?: $this->currentStep;

        if (is_string($step)) {
            $step = $this->flow->getStep($step);
        }

        return $this->storage->has($step->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function setStepData($step = null, array $stepData)
    {
        $step = $step ?: $this->currentStep;

        if (is_string($step)) {
            $step = $this->flow->getStep($step);
        }

        $this->storage->set($step->getName(), $stepData);
    }

    /**
     * {@inheritdoc}
     */
    public function rewindHistory()
    {
        $history = $this->getStepHistory();

        while ($top = end($history)) {
            if ($top != $this->currentStep->getName()) {
                array_pop($history);
            } else {
                break;
            }
        }

        if (0 === count($history)) {
            //throw new StepAccessException($this->currentStep->getName());
        }

        $this->setStepHistory($history);
    }

    /**
     * {@inheritdoc}
     */
    public function setInitialParameters(array $params = null)
    {
        $this->storage->set('initial_params', $params);
    }

    /**
     * {@inheritdoc}
     */
    public function getInitialParameters()
    {
        return $this->storage->get('initial_params', array());
    }

    /**
     * Test if context has been initialized.
     *
     * @throws ContextNotInitializedException When context has not been initialized.
     * @return true
     */
    protected function assertInitialized()
    {
        if (!$this->initialized) {
            throw new ContextNotInitializedException();
        }

        return true;
    }

    /*
     * Calculates progress based on current step index.
     *
     * @param integer $currentStepIndex
     */
    protected function calculateProgress($currentStepIndex)
    {
        $totalSteps = $this->flow->countSteps();

        return floor(($currentStepIndex + 1) / $totalSteps * 100);
    }
}
