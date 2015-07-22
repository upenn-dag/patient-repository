<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\DependencyInjection;

use Accard\Component\Core\Version;
use DAG\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Accard core bundle extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardCoreExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    /**
     * @var array
     */
    protected $bundles = array(
        'accard_resource',
        'accard_settings',
        'accard_field',
        'accard_prototype',
        'accard_option',
        'accard_patient',
        'accard_diagnosis',
        'accard_phase',
        'accard_import',
        'accard_behavior',
        'accard_attribute',
        'accard_sample',
        'accard_regimen',
    );

    /**
     * Configuration files to load.
     *
     * @var array
     */
    protected $configFiles = array('services', 'settings', 'forms', 'providers', 'events');


    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        list($config, $loader) = $this->configure($config, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS | self::CONFIGURE_VALIDATORS);

        $container->setParameter('accard.core_version.simple', Version::SIMPLE);
        $container->setParameter('accard.core_version.major', Version::MAJOR);
        $container->setParameter('accard.core_version.minor', Version::MINOR);
        $container->setParameter('accard.core_version.release', Version::RELEASE);
        $container->setParameter('accard.core_version.id', Version::ID);
        $container->setParameter('accard.core_version.preview', Version::PREVIEW);
        $container->setParameter('accard.core_version.preview_type', Version::PREVIEW_TYPE);
        $container->setParameter('accard.core_version.preview_number', Version::PREVIEW_NUMBER);
        $container->setParameter('accard.core_version.full', Version::FULL);
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $container->getExtensionConfig($this->getAlias()));

        foreach ($container->getExtensions() as $name => $extension) {
            if (in_array($name, $this->bundles)) {
                $container->prependExtensionConfig($name, array('driver' => $config['driver']));
            }
        }
    }
}
