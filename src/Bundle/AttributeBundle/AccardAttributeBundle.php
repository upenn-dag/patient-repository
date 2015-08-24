<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\AttributeBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use DAG\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Accard attribute bundle.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class AccardAttributeBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Component\Attribute\Model\AttributeInterface' => 'accard.model.attribute.class',
            'Accard\Component\Attribute\Model\FieldInterface' => 'accard.model.attribute_field.class',
            'Accard\Component\Attribute\Model\FieldValueInterface' => 'accard.model.attribute_field_value.class',
            'Accard\Component\Attribute\Model\PrototypeInterface' => 'accard.model.attribute_prototype.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_attribute', $interfaces), PassConfig::TYPE_BEFORE_REMOVING);

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Component\Attribute\Model',
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createXmlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_attribute.driver.doctrine/orm'
            )
        );
    }
}
