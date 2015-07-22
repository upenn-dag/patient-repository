<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\RegimenBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use DAG\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use DAG\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Accard regimen bundle.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardRegimenBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Component\Regimen\Model\RegimenInterface' => 'accard.model.regimen.class',
            'Accard\Component\Regimen\Model\FieldInterface' => 'accard.model.regimen_field.class',
            'Accard\Component\Regimen\Model\FieldValueInterface' => 'accard.model.regimen_field_value.class',
            'Accard\Component\Regimen\Model\PrototypeInterface' => 'accard.model.regimen_prototype.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_regimen', $interfaces));

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Component\Regimen\Model',
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createYamlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_regimen.driver.doctrine/orm'
            )
        );
    }
}
