<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SettingsBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Accard\Bundle\SettingsBundle\DependencyInjection\Compiler\RegisterSchemasPass;
use Accard\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Accard\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Accard settings bundle definition.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardSettingsBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Accard\Bundle\SettingsBundle\Model\ParameterInterface' => 'accard.model.parameter.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_settings', $interfaces));
        $container->addCompilerPass(new RegisterSchemasPass());

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Bundle\SettingsBundle\Model',
        );

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createYamlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_settings.driver.doctrine/orm'
            )
        );
    }
}
