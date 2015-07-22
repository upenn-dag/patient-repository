<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PatientBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use DAG\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use DAG\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Accard patient bundle.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardPatientBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Component\Patient\Model\PatientInterface' => 'accard.model.patient.class',
            'Accard\Component\Patient\Model\FieldInterface' => 'accard.model.patient_field.class',
            'Accard\Component\Patient\Model\FieldValueInterface' => 'accard.model.patient_field_value.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_patient', $interfaces));

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Component\Patient\Model',
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createYamlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_patient.driver.doctrine/orm'
            )
        );
    }
}
