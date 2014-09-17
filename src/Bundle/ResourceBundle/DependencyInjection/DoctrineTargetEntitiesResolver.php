<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Accard\Bundle\ResourceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use InvalidArgumentException;

/**
 * Resolves given target entities with container parameters.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DoctrineTargetEntitiesResolver
{
    /**
     * {@inheritdoc}
     */
    public function resolve(ContainerBuilder $container, array $interfaces)
    {
        if (!$container->hasDefinition('doctrine.orm.listeners.resolve_target_entity')) {
            throw new \RuntimeException('Cannot find Doctrine RTEL');
        }

        $listener = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');

        foreach ($interfaces as $interface => $model) {
            $listener
                ->addMethodCall('addResolveTargetEntity', array(
                    $this->getInterface($container, $interface),
                    $this->getClass($container, $model),
                    array()
                ))
            ;
        }

        if (!$listener->hasTag('doctrine.event_listener')) {
            $listener->addTag('doctrine.event_listener', array('event' => 'loadClassMetadata'));
        }
    }

    /**
     * Get interface or container definition.
     *
     * @param ContainerBuilder $container
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     */
    private function getInterface(ContainerBuilder $container, $key)
    {
        if ($container->hasParameter($key)) {
            return $container->getParameter($key);
        }

        if (interface_exists($key)) {
            return $key;
        }

        throw new InvalidArgumentException(
            sprintf('The interface %s does not exist.', $key)
        );
    }

    /**
     * Get class or container defintion.
     *
     * @param ContainerBuilder $container
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     */
    private function getClass(ContainerBuilder $container, $key)
    {
        if ($container->hasParameter($key)) {
            return $container->getParameter($key);
        }

        if (class_exists($key)) {
            return $key;
        }

        throw new InvalidArgumentException(
            sprintf('The class %s does not exist.', $key)
        );
    }
}
