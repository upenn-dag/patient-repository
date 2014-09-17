<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Accard\Bundle\ResourceBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Accard\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Accard\Bundle\ResourceBundle\DependencyInjection\Compiler\ObjectToIdentifierServicePass;
use Accard\Bundle\ResourceBundle\DependencyInjection\Compiler\RegisterImporterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Resource bundle.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardResourceBundle extends Bundle
{
    // Bundle driver list.
    const DRIVER_DOCTRINE_ORM         = 'doctrine/orm';
    const DRIVER_DOCTRINE_MONGODB_ODM = 'doctrine/mongodb-odm';
    const DRIVER_DOCTRINE_PHPCR_ODM   = 'doctrine/phpcr-odm';

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
            'Accard\Component\Resource\Model\ImportInterface' => 'accard.model.import.class',
        );

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Accard\Component\Resource\Model',
        );

        $container->addCompilerPass(new ObjectToIdentifierServicePass());
        $container->addCompilerPass(new RegisterImporterPass());
        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('accard_resource', $interfaces));
        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createYamlMappingDriver(
                $mappings,
                array('doctrine.orm.entity_manager'),
                'accard_resource.driver.doctrine/orm'
            )
        );
    }
}
