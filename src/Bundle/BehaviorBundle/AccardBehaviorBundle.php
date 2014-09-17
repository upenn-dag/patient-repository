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
use Accard\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Accard\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
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
     * Return array with currently supported drivers.
     *
     * @return array
     */
    public static function getSupportedDrivers()
    {
        return array(
            AccardResourceBundle::DRIVER_DOCTRINE_ORM
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Component\Behavior\Model\BehaviorInterface' => 'accard.model.behavior.class',
            'Accard\Component\Behavior\Model\AlcoholBehaviorInterface' => 'accard.model.alcohol_behavior.class',
            'Accard\Component\Behavior\Model\SmokingBehaviorInterface' => 'accard.model.smoking_behavior.class',
            'Accard\Component\Behavior\Model\IllicitDrugBehaviorInterface' => 'accard.model.illicit_drug_behavior.class',
            'Accard\Component\Behavior\Model\OccupationBehaviorInterface' => 'accard.model.occupation_behavior.class',
            'Accard\Component\Behavior\Model\EducationBehaviorInterface' => 'accard.model.education_behavior.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_behavior', $interfaces));

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
