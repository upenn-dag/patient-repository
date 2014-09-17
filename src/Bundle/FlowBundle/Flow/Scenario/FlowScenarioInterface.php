<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Flow\Scenario;

use Accard\Bundle\FlowBundle\Flow\Builder\FlowBuilderInterface;

/**
 * Flow scenario interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FlowScenarioInterface
{
    /**
     * Scenario builder.
     *
     * @param FlowBuilderInterface $builder
     */
    public function build(FlowBuilderInterface $builder);
}
