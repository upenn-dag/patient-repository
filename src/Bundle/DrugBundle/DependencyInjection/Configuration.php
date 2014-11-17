<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DrugBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Accard drug bundle configuration.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('accard_drug');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')->defaultValue('doctrine/orm')->cannotBeEmpty()->end()
            ->end()
        ;

        $this->addClassesSection($rootNode);
        $this->addValidationGroupsSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds validation_groups section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addValidationGroupsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('validation_groups')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('drug')
                            ->prototype('scalar')->end()
                            ->defaultValue(array('accard'))
                        ->end()
                        ->arrayNode('drug_group')
                            ->prototype('scalar')->end()
                            ->defaultValue(array('accard'))
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Adds classes section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('drug')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('Accard\Component\Drug\Model\Drug')->end()
                                ->scalarNode('controller')->defaultValue('Accard\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('Accard\Bundle\DrugBundle\Doctrine\ORM\DrugRepository')->end()
                                ->scalarNode('form')->defaultValue('Accard\Bundle\DrugBundle\Form\Type\DrugType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('drug_group')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('Accard\Component\Drug\Model\DrugGroup')->end()
                                ->scalarNode('controller')->defaultValue('Accard\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('Accard\Bundle\DrugBundle\Doctrine\ORM\DrugGroupRepository')->end()
                                ->scalarNode('form')->defaultValue('Accard\Bundle\DrugBundle\Form\Type\DrugGroupType')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
