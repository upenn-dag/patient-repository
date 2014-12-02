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
     * Set options.
     *
     * @param array $options
     * @return StepInterface
     */
    public function setOptions(array $options);

    /**
     * Get options.
     *
     * @return array
     */
    public function getOptions();

    /**
     * Set option by key.
     *
     * @param string $key
     * @param mixed $value
     * @return StepInterface
     */
    public function setOption($key, $value);

    /**
     * Test for presence of option.
     *
     * @param string $key
     * @return boolean
     */
    public function hasOption($key);

    /**
     * Get option by key, or default.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getOption($key, $default = null);

    /**
     * Test if step is active.
     *
     * @return boolean
     */
    public function isActive();

    /**
     * Test if step has been skipped.
     *
     * @return boolean
     */
    public function isSkipped();
}
