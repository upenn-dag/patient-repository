<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DrugBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use DAG\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Accard drug bundle.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardDrugBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Component\Drug\Model\DrugInterface' => 'accard.model.drug.class',
            'Accard\Component\Drug\Model\DrugGroupInterface' => 'accard.model.drug_group.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_drug', $interfaces), PassConfig::TYPE_BEFORE_REMOVING);

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Component\Drug\Model',
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createYamlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_drug.driver.doctrine/orm'
            )
        );
    }
}
