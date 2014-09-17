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

use Accard\Bundle\FlowBundle\Flow\Context\FlowContextInterface;

/**
 * Flow step interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface StepInterface
{
    /**
     * Get step name.
     *
     * @return string
     */
    public function getName();

    /**
     * Complete action.
     *
     * @param FlowContextInterface $context
     * @return ResultInterface
     */
    public function complete(FlowContextInterface $context);

    /**
     * Display action.
     *
     * @param FlowContextInterface $context
     * @return ResultInterface
     */
    public function display(FlowContextInterface $context);

    /**
     * Skip indicator.
     *
     * @param FlowContextInterface $context
     * @return ResultInterface
     */
    public function skip(FlowContextInterface $context);

    /**
     * Test if step is active.
     *
     * @return boolean
     */
    public function isActive();
}
