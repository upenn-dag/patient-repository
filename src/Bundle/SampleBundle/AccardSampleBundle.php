<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SampleBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use DAG\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Accard sample bundle.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardSampleBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Component\Sample\Model\SampleInterface' => 'accard.model.sample.class',
            'Accard\Component\Sample\Model\FieldInterface' => 'accard.model.sample_field.class',
            'Accard\Component\Sample\Model\FieldValueInterface' => 'accard.model.sample_field_value.class',
            'Accard\Component\Sample\Model\PrototypeInterface' => 'accard.model.sample_prototype.class',
            'Accard\Component\Sample\Model\SourceInterface' => 'accard.model.sample_source.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_sample', $interfaces), PassConfig::TYPE_BEFORE_REMOVING);

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Component\Sample\Model',
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createXmlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_sample.driver.doctrine/orm'
            )
        );
    }
}
