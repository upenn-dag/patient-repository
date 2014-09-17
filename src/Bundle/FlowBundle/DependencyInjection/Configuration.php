<?php

namespace Accard\Bundle\FlowBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('accard_flow');

        $rootNode
            ->children()
                ->scalarNode('default_start_route')
                    ->defaultValue('accard_flow_start')
                    ->info('Default route to use for flow start action.')
                ->end()
                ->scalarNode('default_display_route')
                    ->defaultValue('accard_flow_display')
                    ->info('Default route to use for flow display action.')
                ->end()
                ->scalarNode('default_forward_route')
                    ->defaultValue('accard_flow_forward')
                    ->info('Default route to use for flow forward action.')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
