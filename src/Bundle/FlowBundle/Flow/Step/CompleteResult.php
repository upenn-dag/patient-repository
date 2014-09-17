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

/**
 * Complete step result.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CompleteResult extends AbstractResult
{
    /**
     * Completion step name.
     *
     * @var boolean
     */
    private $step;


    /**
     * Constructor.
     *
     * @param boolean|null $step
     */
    public function __construct($step = null)
    {
        $this->step = $step;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this->step;
    }

    public function getNextStep()
    {
        return $this->step;
    }
}
