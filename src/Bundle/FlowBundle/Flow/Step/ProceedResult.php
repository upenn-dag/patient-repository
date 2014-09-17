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

use LogicException;

/**
 * Proceed step result.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ProceedResult extends AbstractResult
{
    /**
     * Proceed status.
     *
     * @var string
     */
    private $status;

    /**
     * Proceed step name.
     *
     * @var string|null
     */
    private $stepName;


    /**
     * Constructor.
     *
     * @param string $status
     * @param string|null $stepName
     */
    public function __construct($status, $stepName = null)
    {
        if (self::GOTO === $status && empty($stepName)) {
            throw new LogicException('No step provided for "goto" step result.');
        }

        $this->status = $status;
        $this->stepName = $stepName;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return self::GOTO === $status ? $this->stepName : $this->status;
    }
}
