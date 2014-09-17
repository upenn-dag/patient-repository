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
 * Ordered flow step interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface OrderedStepInterface extends StepInterface
{
    /**
     * Get order.
     *
     * @return integer
     */
    public function getOrder();
}
