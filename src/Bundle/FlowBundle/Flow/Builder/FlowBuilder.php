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

use Accard\Bundle\FlowBundle\Flow\Flow;
use Accard\Bundle\FlowBundle\Flow\FlowInterface;
use Accard\Bundle\FlowBundle\Flow\Step\StepRegistry;
use Accard\Bundle\FlowBundle\Flow\Step\StepInterface;
use Accard\Bundle\FlowBundle\Flow\Step\OrderedStepInterface;
use Accard\Bundle\FlowBundle\Flow\Scenario\FlowScenarioInterface;
use Accard\Bundle\FlowBundle\Exception\StepAccessException;
use Accard\Bundle\FlowBundle\Exception\DuplicateStepException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Flow builder.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FlowBuilder implements FlowBuilderInterface
{
    /**
     * Container.
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Step registry.
     *
     * @param StepRegistry
     */
    protected $stepRegistry;

    /**
     * Steps.
     *
     * @var array
     */
    protected $steps;

    /**
     * Current flow.
     *
     * @var FlowInterface
     */
    protected $flow;

    /**
     * State machine graph.
     *
     * @var array
     */
    protected $graph;

    /**
     * Default display route.
     *
     * @var string
     */
    protected $defaultDisplayRoute;

    /**
     * Default start route.
     *
     * @var string
     */
    protected $defaultStartRoute;

    /**
     * Default forward route.
     *
     * @var string
     */
    protected $defaultForwardRoute;


    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->stepRegistry = $container->get('accard.flow.step_registry');
        $this->defaultDisplayRoute = $container->getParameter('accard.flow.default_display_route');
        $this->defaultStartRoute = $container->getParameter('accard.flow.default_start_route');
        $this->defaultForwardRoute = $container->getParameter('accard.flow.default_forward_route');
    }

    /**
     * {@inheritdoc}
     */
    public function build(FlowScenarioInterface $scenario)
    {
        $this->flow = new Flow();

        $this->setDisplayRoute($this->defaultDisplayRoute);
        $this->setStartRoute($this->defaultStartRoute);
        $this->setForwardRoute($this->defaultForwardRoute);
        $scenario->build($this);

        if (!$this->flow->getSaveCallback()) {
            $this->flow->setSaveCallback(function() {});
        }

        return $this->flow;
    }

    /**
     * {@inheritdoc}
     */
    public function get($alias)
    {
        $this->assertHasFlow();

        return $this->flow->getStepByAlias($alias);
    }

    /**
     * {@inheritdoc}
     */
    public function has($step)
    {
        $this->assertHasFlow();

        return $this->flow->hasStepByAlias($alias);
    }

    /**
     * {@inheritdoc}
     */
    public function add($alias, array $options = array())
    {
        $this->assertHasFlow();

        if (is_string($alias)) {
            $step = $this->load($alias);
        }

        if ($step instanceof ContainerAwareInterface) {
            $step->setContainer($this->container);
        }

        $this->flow->addStep($alias, $step, $options);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($alias)
    {
        $this->assertHasFlow();
        $this->flow->removeByName($step);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDisplayRoute($displayRoute)
    {
        $this->assertHasFlow();
        $this->flow->setDisplayRoute($displayRoute);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartRoute($startRoute)
    {
        $this->assertHasFlow();
        $this->flow->setStartRoute($startRoute);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setForwardRoute($forwardRoute)
    {
        $this->assertHasFlow();
        $this->flow->setForwardRoute($forwardRoute);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRedirect($route, array $params = null)
    {
        if (is_callable($route)) {
            return $this->flow->setRedirectRoute($route);
        }

        $this->flow->setRedirectRoute($route);
        $this->flow->setRedirectParams($params ?: array());
    }

    /**
     * {@inheritdoc}
     */
    public function setSaveCallback(callable $callback)
    {
        $this->flow->setSaveCallback($callback);
    }

    /**
     * Test if object has been properly initialized.
     *
     * @throws FlowNotInitializedException When flow has not been initialized.
     */
    protected function assertHasFlow()
    {
        if (!$this->flow instanceof FlowInterface) {
            throw new FlowNotInitializedException();
        }
    }

    /**
     * Load step.
     *
     * @param string $step
     * @return StepInterface
     */
    protected function load($step)
    {
        return $this->stepRegistry->get($step);
    }
}
