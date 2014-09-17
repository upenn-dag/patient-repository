<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Accard\Bundle\FlowBundle\DependencyInjection\Compiler\RegisterScenariosPass;
use Accard\Bundle\FlowBundle\DependencyInjection\Compiler\RegisterStepsPass;
use Accard\Bundle\FlowBundle\DependencyInjection\Compiler\RegisterSessionBagsPass;

/**
 * Accard flow bundle definition.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardFlowBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterScenariosPass());
        $container->addCompilerPass(new RegisterStepsPass());
        $container->addCompilerPass(new RegisterSessionBagsPass());
    }
}
