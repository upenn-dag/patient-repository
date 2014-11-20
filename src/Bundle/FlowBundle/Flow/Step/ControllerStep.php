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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Accard\Bundle\FlowBundle\Flow\Context\FlowContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Abstract controller step.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class ControllerStep extends Controller implements StepInterface
{
    /**
     * Step name.
     *
     * @var string
     */
    protected $name;

    /**
     * Step active.
     *
     * @var boolean
     */
    protected $active = false;

    /**
     * Step is skipped.
     *
     * @var boolean
     */
    protected $skipped = false;


    /**
     * Set step name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function complete(FlowContextInterface $context)
    {
        $nextStep = $context->isLastStep() ? null : $context->getNextStep()->getName();

        return new CompleteResult($nextStep);
    }

    /**
     * {@inheritdoc}
     */
    public function skip(FlowContextInterface $context)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * {@inheritdoc}
     */
    public function setActive($active)
    {
        $this->active = (boolean) $active;
    }

    /**
     * {@inheritdoc}
     */
    public function isSkipped()
    {
        return $this->skipped;
    }

    /**
     * {@inheritdoc}
     */
    public function setSkipped($skipped)
    {
        $this->skipped = (boolean) $skipped;
    }
}
