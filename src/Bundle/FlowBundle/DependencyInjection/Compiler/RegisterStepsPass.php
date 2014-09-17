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
 * Register steps compiler pass.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegisterStepsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition('accard.flow.step_registry');

        foreach ($container->findTaggedServiceIds('accard.flow.step') as $id => $attributes) {
            $registry->addMethodCall('register', array($attributes[0]['alias'], new Reference($id)));
        }
    }
}
