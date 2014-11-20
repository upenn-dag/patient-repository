<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Flow\Coordinator;

use Closure;
use Accard\Bundle\FlowBundle\Flow\FlowInterface;
use Accard\Bundle\FlowBundle\Flow\Scenario\FlowScenarioInterface;
use Accard\Bundle\FlowBundle\Flow\Builder\FlowBuilderInterface;
use Accard\Bundle\FlowBundle\Flow\Context\FlowContextInterface;
use Accard\Bundle\FlowBundle\Flow\Step\StepInterface;
use Accard\Bundle\FlowBundle\Flow\Step\CompleteResult;
use Accard\Bundle\FlowBundle\Exception\DuplicateScenarioException;
use Accard\Bundle\FlowBundle\Exception\ScenarioAccessException;
use Accard\Bundle\FlowBundle\Exception\StepAccessException;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Flow coordinator.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FlowCoordinator implements FlowCoordinatorInterface
{
    /**
     * Router.
     *
     * @var RouterInterface
     */
    private $router;

    /**
     * Flow builder.
     *
     * @var FlowBuilderInterface
     */
    private $builder;

    /**
     * Flow context.
     *
     * @var FlowContextInterface
     */
    private $context;

    /**
     * Flow scenarios.
     *
     * @var array|FlowScenarioInterface[]
     */
    private $scenarios;


    /**
     * Constructor.
     */
    public function __construct(RouterInterface $router,
                                FlowBuilderInterface $builder,
                                FlowContextInterface $context)
    {
        $this->router = $router;
        $this->builder = $builder;
        $this->context = $context;
        $this->scenarios = array();
    }

    /**
     * {@inheritdoc}
     */
    public function start($scenarioAlias, ParameterBag $params = null)
    {
        $flow = $this->buildFlow($scenarioAlias);
        $step = $flow->getFirstStep();

        $this->context->initialize($flow, $step);
        $this->context->close();
        $this->context->setInitialParameters($params->all());

        // Issue redirect to get to first step.
        return $this->redirect($flow, $step, null);
    }

    /**
     * {@inheritdoc}
     */
    public function display($scenarioAlias, $stepName, ParameterBag $params = null)
    {
        $flow = $this->buildFlow($scenarioAlias);
        $step = $flow->getStep($stepName);

        $this->context->initialize($flow, $step);
        $this->context->rewindHistory();

        // Need to account for last step skipping.
        if ($step->skip($this->context)) {
            $nextStep = $this->context->getNextStep();

            if (null === $nextStep) {
                throw new \Exception('Last step cannot be skipped, for now.');
            }

            return $this->redirect($flow, $nextStep, $params);
        }

        $step->setActive(true);

        // Loop through all steps and test to see if they have been,
        // or will be skipped.
        foreach ($flow->getSteps() as $loopStep) {
            $loopStep->setSkipped($loopStep->skip($this->context));
        }

        $result = $step->display($this->context);

        return $this->processStepResult($flow, $result);
    }

    /**
     * {@inheritdoc}
     */
    public function forward($scenarioAlias, $stepName)
    {
        $flow = $this->buildFlow($scenarioAlias);
        $step = $flow->getStep($stepName);

        $this->context->initialize($flow, $step);
        $this->context->rewindHistory();

        $result = $step->complete($this->context);

        return $this->processStepResult($flow, $result);
    }

    /**
     * Process step result.
     *
     * Take the result of a step action, processes it and returns a controller
     * usable result for display.
     *
     * @param FlowInterface $flow
     * @param mixed $result
     */
    private function processStepResult(FlowInterface $flow, $result)
    {
        // Return response or view directly, process result object, or throw an exception.
        if ($result instanceof Response) {
            return $result;
        }

        if ($result instanceof CompleteResult) {
            if ($this->context->isLastStep()) {
                // Calls the supplied save method, providing the context
                call_user_func($flow->getSaveCallback(), $this->context);
                $this->context->close();

                // Allow dynamic redirect via a closure...
                $route = $flow->getRedirectRoute();

                if (null === $route) {
                    $route = $flow->getStartRoute();
                    $params = array('scenarioAlias' => $flow->getScenarioAlias());
                } elseif (is_string($route)) {
                    $params = $flow->getRedirectParams();
                } elseif ($route instanceof Closure) {
                    $url = call_user_func($route, $this->context, $this->router);

                    return new RedirectResponse($url);
                }

                return new RedirectResponse($this->router->generate($route, $params));
            }

            return $this->redirect($flow, $flow->getStep($result->getResult()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function redirect(FlowInterface $flow, StepInterface $step, ParameterBag $params = null)
    {
        $this->context->addStepToHistory($step->getName());

        $routeParams = array(
            'scenarioAlias' => $flow->getScenarioAlias(),
            'stepName' => $step->getName(),
        );

        if ($params) {
            $routeParams = array_merge($params->all(), $routeParams);
        }

        $url = $this->router->generate($flow->getDisplayRoute(), $routeParams);

        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function registerScenario($alias, FlowScenarioInterface $scenario)
    {
        if (isset($this->scenarios[$alias])) {
            throw new DuplicateScenarioException($scenario);
        }

        $this->scenarios[$alias] = $scenario;
    }

    /**
     * {@inheritdoc}
     */
    public function getScenario($alias)
    {
        if (!$this->hasScenario($alias)) {
            throw new ScenarioAccessException($alias);
        }

        return $this->scenarios[$alias];
    }

    /**
     * {@inheritdoc}
     */
    public function hasScenario($alias)
    {
        return isset($this->scenarios[$alias]);
    }

    /**
     * {@inheritdoc}
     */
    protected function buildFlow($scenarioAlias)
    {
        $scenario = $this->getScenario($scenarioAlias);
        $flow = $this->builder->build($scenario);
        $flow->setScenarioAlias($scenarioAlias);

        return $flow;
    }
}
