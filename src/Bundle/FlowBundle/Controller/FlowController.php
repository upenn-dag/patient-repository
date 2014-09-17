<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Controller;

use Accard\Bundle\FlowBundle\Exception\StepException;
use Accard\Bundle\FlowBundle\Flow\Context\FlowContextInterface;
use Accard\Bundle\FlowBundle\Flow\Coordinator\FlowCoordinatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Flow controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FlowController
{
    /**
     * Flow coordinator.
     *
     * @var FlowCoordinatorInterface
     */
    protected $flowCoordinator;

    /**
     * Flow context.
     *
     * @var FlowContextInterface
     */
    protected $flowContext;


    /**
     * Constructor.
     *
     * @param FlowCoordinatorInterface $coordinator
     * @param FlowContextInterface $context
     */
    public function __construct(FlowCoordinatorInterface $coordinator, FlowContextInterface $context)
    {
        $this->flowCoordinator = $coordinator;
        $this->flowContext = $context;
    }

    /**
     * Start action.
     *
     * Build and start a given scenario, normally the first step.
     *
     * @param Request $request
     * @param string $scenarioAlias
     * @return Response
     */
    public function startAction(Request $request, $scenarioAlias)
    {
        $this->flowContext->setRequest($request);

        return $this->flowCoordinator->start($scenarioAlias, $request->query);
    }

    /**
     * Display action.
     *
     * Execute the display action for a given step.
     *
     * @param Request $request
     * @param string $scenarioAlias
     * @param string $stepName
     * @return Response
     */
    public function displayAction(Request $request, $scenarioAlias, $stepName)
    {
        $this->flowContext->setRequest($request);

        try {
            return $this->flowCoordinator->display($scenarioAlias, $stepName, $request->query);
        } catch (StepException $e) {
            throw new NotFoundHttpException('The step you requested could not be found.', $e);
        }
    }

    /**
     * Forward action.
     *
     * Execute the continue action for a given step.
     *
     * @param Request $request
     * @param string $scenarioAlias
     * @param string $stepName
     * @return Response
     */
    public function forwardAction(Request $request, $scenarioAlias, $stepName)
    {
        $this->flowContext->setRequest($request);

        return $this->flowCoordinator->forward($scenarioAlias, $stepName);
    }
}
