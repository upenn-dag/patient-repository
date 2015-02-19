<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers all importer managers.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class RegisterImporterManagerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('accard.import.manager_registry')) {
            return;
        }

        $registry = $container->getDefinition('accard.import.manager_registry');

        foreach ($container->findTaggedServiceIds('accard.manager') as $id => $attributes) {
            $registry->addMethodCall('registerManager', array($attributes[0]['manager'], $id));
        }
    }
}
