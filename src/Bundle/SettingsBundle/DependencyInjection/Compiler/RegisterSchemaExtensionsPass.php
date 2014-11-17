<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SettingsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use InvalidArgumentException;

/**
 * Registers all settings schema extensions.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegisterSchemaExtensionsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('accard.settings.schema_registry')) {
            return;
        }

        $registry = $container->getDefinition('accard.settings.schema_registry');

        foreach ($container->findTaggedServiceIds('accard.settings_extension') as $id => $attributes) {
            if (!array_key_exists('namespace', $attributes[0])) {
                throw new InvalidArgumentException(sprintf(
                    'Service "%s" must define the "namespace" attribute on "accard.settings_extension" tags.',
                    $id
                ));
            }

            $namespace = $attributes[0]['namespace'];
            $registry->addMethodCall('registerExtension', array($namespace, new Reference($id)));
        }
    }
}
