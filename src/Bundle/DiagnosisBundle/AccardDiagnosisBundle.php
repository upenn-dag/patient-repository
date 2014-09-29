<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Accard\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Accard\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Accard diagnosis bundle.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardDiagnosisBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Component\Diagnosis\Model\CodeInterface' => 'accard.model.diagnosis_code.class',
            'Accard\Component\Diagnosis\Model\CodeGroupInterface' => 'accard.model.diagnosis_code_group.class',
            'Accard\Component\Diagnosis\Model\DiagnosisInterface' => 'accard.model.diagnosis.class',
            'Accard\Component\Diagnosis\Model\FieldInterface' => 'accard.model.diagnosis_field.class',
            'Accard\Component\Diagnosis\Model\FieldValueInterface' => 'accard.model.diagnosis_field_value.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_diagnosis', $interfaces));

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Component\Diagnosis\Model',
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createYamlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_diagnosis.driver.doctrine/orm'
            )
        );
    }
}
