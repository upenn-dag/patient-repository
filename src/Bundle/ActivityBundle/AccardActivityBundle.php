<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ActivityBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Accard\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Accard\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Accard activity bundle.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardActivityBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Component\Activity\Model\ActivityInterface' => 'accard.model.activity.class',
            'Accard\Component\Activity\Model\FieldInterface' => 'accard.model.activity_field.class',
            'Accard\Component\Activity\Model\FieldValueInterface' => 'accard.model.activity_field_value.class',
            'Accard\Component\Activity\Model\PrototypeInterface' => 'accard.model.activity_prototype.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_activity', $interfaces));

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Component\Activity\Model',
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createYamlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_activity.driver.doctrine/orm'
            )
        );
    }
}
