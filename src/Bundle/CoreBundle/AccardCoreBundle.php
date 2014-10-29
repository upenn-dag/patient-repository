<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Accard\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Accard\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Accard core bundle definition.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardCoreBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Component\Core\Model\ImportPatientInterface' => 'accard.model.import_patient.class',
            'Accard\Component\Core\Model\ImportActivityInterface' => 'accard.model.import_activity.class',
            'Accard\Component\Core\Model\PatientPhaseInterface' => 'accard.model.patient_phase.class',
            'Accard\Component\Core\Model\PatientPhaseInstanceInterface' => 'accard.model.patient_phase_instance.class',
            'Accard\Component\Core\Model\DiagnosisPhaseInterface' => 'accard.model.diagnosis_phase.class',
            'Accard\Component\Core\Model\DiagnosisPhaseInstanceInterface' => 'accard.model.diagnosis_phase_instance.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_core', $interfaces));

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Component\Core\Model',
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createYamlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_core.driver.doctrine/orm'
            )
        );
    }
}
