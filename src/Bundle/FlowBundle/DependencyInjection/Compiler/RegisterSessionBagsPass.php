<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Register session bags compiler pass.
 * 
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegisterSessionBagsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $session = $container->getDefinition('session');
        $session->addMethodCall('registerBag', array(new Reference('accard.flow.storage.session.bag')));
    }
}
