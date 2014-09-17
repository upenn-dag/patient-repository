<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\AttributeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Accard attribute bundle configuration.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('accard_attributes');

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
                        ->arrayNode('attribute')
                            ->prototype('scalar')->end()
                            ->defaultValue(array('accard'))
                        ->end()
                        ->arrayNode('family_cancer_attribute')
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
        $defaultInheritance = array(
            'family_cancer_attribute',
        );

        $node
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('attribute')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('children')
                                    ->prototype('scalar')->end()
                                    ->defaultValue($defaultInheritance)
                                ->end()
                                ->scalarNode('model')->defaultValue('Accard\Component\Attribute\Model\Attribute')->end()
                                ->scalarNode('controller')->defaultValue('Accard\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('Accard\Bundle\AttributeBundle\Doctrine\ORM\AttributeRepository')->end()
                                ->scalarNode('form')->defaultValue('Accard\Bundle\AttributeBundle\Form\Type\AttributeType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('family_cancer_attribute')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('parent')->defaultValue('attribute')->end()
                                ->scalarNode('model')->defaultValue('Accard\Component\Core\Model\FamilyCancerAttribute')->end()
                                ->scalarNode('controller')->defaultValue('Accard\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('Accard\Bundle\AttributeBundle\Doctrine\ORM\AttributeRepository')->end()
                                ->scalarNode('form')->defaultValue('Accard\Bundle\AttributeBundle\Form\Type\FamilyCancerAttributeType')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
