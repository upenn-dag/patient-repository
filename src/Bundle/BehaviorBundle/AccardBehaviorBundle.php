<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\BehaviorBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use DAG\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Accard behavior bundle.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class AccardBehaviorBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Component\Behavior\Model\BehaviorInterface' => 'accard.model.behavior.class',
            'Accard\Component\Behavior\Model\FieldInterface' => 'accard.model.behavior_field.class',
            'Accard\Component\Behavior\Model\FieldValueInterface' => 'accard.model.behavior_field_value.class',
            'Accard\Component\Behavior\Model\PrototypeInterface' => 'accard.model.behavior_prototype.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_behavior', $interfaces), PassConfig::TYPE_BEFORE_REMOVING);

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Component\Behavior\Model',
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createYamlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_behavior.driver.doctrine/orm'
            )
        );
    }

}
