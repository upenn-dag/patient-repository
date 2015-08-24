<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Accard outcomes extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardOutcomesExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        if ($container->hasExtension("jms_serializer")) {
            $container->prependExtensionConfig("jms_serializer", $this->createJmsSerializerConfig());
        }
    }

    /**
     * Create the base JMS Serializer config to include outcomes definitions.
     *
     * @return array
     */
    private function createJmsSerializerConfig()
    {
        $config = array(
            "metadata" => array(
                "directories" => array(
                    "outcomes" => array(
                        "namespace_prefix" => "Accard\\Bundle\\OutcomesBundle\\Outcomes",
                        "path" => "@AccardOutcomesBundle/Resources/serializer"
                    )
                )
            )
        );

        return $config;
    }
}
