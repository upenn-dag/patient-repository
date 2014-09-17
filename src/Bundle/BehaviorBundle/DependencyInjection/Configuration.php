<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\BehaviorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Accard behavior bundle configuration.
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
        $rootNode = $treeBuilder->root('accard_behavior');

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
                        ->arrayNode('behavior')
                            ->prototype('scalar')->end()
                            ->defaultValue(array('accard'))
                        ->end()
                        ->arrayNode('alcohol_behavior')
                            ->prototype('scalar')->end()
                            ->defaultValue(array('accard'))
                        ->end()
                        ->arrayNode('smoking_behavior')
                            ->prototype('scalar')->end()
                            ->defaultValue(array('accard'))
                        ->end()
                        ->arrayNode('illicit_drug_behavior')
                            ->prototype('scalar')->end()
                            ->defaultValue(array('accard'))
                        ->end()
                        ->arrayNode('occupation_behavior')
                            ->prototype('scalar')->end()
                            ->defaultValue(array('accard'))
                        ->end()
                        ->arrayNode('education_behavior')
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
            'alcohol_behavior',
            'smoking_behavior',
            'illicit_drug_behavior',
            'occupation_behavior',
            'education_behavior',
        );

        $node
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('behavior')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('children')
                                    ->prototype('scalar')->end()
                                    ->defaultValue($defaultInheritance)
                                ->end()
                                ->scalarNode('model')->defaultValue('Accard\Component\Behavior\Model\Behavior')->end()
                                ->scalarNode('controller')->defaultValue('Accard\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('Accard\Bundle\BehaviorBundle\Doctrine\ORM\BehaviorRepository')->end()
                                ->scalarNode('form')->defaultValue('Accard\Bundle\BehaviorBundle\Form\Type\BehaviorType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('alcohol_behavior')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('parent')->defaultValue('behavior')->end()
                                ->scalarNode('model')->defaultValue('Accard\Component\Core\Model\AlcoholBehavior')->end()
                                ->scalarNode('controller')->defaultValue('Accard\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('Accard\Bundle\BehaviorBundle\Doctrine\ORM\BehaviorRepository')->end()
                                ->scalarNode('form')->defaultValue('Accard\Bundle\BehaviorBundle\Form\Type\AlcoholBehaviorType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('smoking_behavior')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('parent')->defaultValue('behavior')->end()
                                ->scalarNode('model')->defaultValue('Accard\Component\Core\Model\SmokingBehavior')->end()
                                ->scalarNode('controller')->defaultValue('Accard\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('Accard\Bundle\BehaviorBundle\Doctrine\ORM\BehaviorRepository')->end()
                                ->scalarNode('form')->defaultValue('Accard\Bundle\BehaviorBundle\Form\Type\SmokingBehaviorType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('illicit_drug_behavior')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('parent')->defaultValue('behavior')->end()
                                ->scalarNode('model')->defaultValue('Accard\Component\Core\Model\IllicitDrugBehavior')->end()
                                ->scalarNode('controller')->defaultValue('Accard\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('Accard\Bundle\BehaviorBundle\Doctrine\ORM\BehaviorRepository')->end()
                                ->scalarNode('form')->defaultValue('Accard\Bundle\BehaviorBundle\Form\Type\IllicitDrugBehaviorType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('occupation_behavior')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('parent')->defaultValue('behavior')->end()
                                ->scalarNode('model')->defaultValue('Accard\Component\Core\Model\OccupationBehavior')->end()
                                ->scalarNode('controller')->defaultValue('Accard\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('Accard\Bundle\BehaviorBundle\Doctrine\ORM\BehaviorRepository')->end()
                                ->scalarNode('form')->defaultValue('Accard\Bundle\BehaviorBundle\Form\Type\OccupationBehaviorType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('education_behavior')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('parent')->defaultValue('behavior')->end()
                                ->scalarNode('model')->defaultValue('Accard\Component\Core\Model\EducationBehavior')->end()
                                ->scalarNode('controller')->defaultValue('Accard\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                ->scalarNode('repository')->defaultValue('Accard\Bundle\BehaviorBundle\Doctrine\ORM\BehaviorRepository')->end()
                                ->scalarNode('form')->defaultValue('Accard\Bundle\BehaviorBundle\Form\Type\EducationBehaviorType')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
