<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Accard\Bundle\ResourceBundle\DependencyInjection\Driver\DatabaseDriverFactory;

/**
 * Resource system extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardResourceExtension extends AbstractResourceExtension
{
    /**
     * {@inheritdoc}
     */
    protected $configFiles = array('services', 'twig', 'widget');

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configure($config, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS | self::CONFIGURE_VALIDATORS);
    }

    /**
     * {@inheritdoc}
     */
    protected function process(array $config, ContainerBuilder $container)
    {
        $container->setParameter('accard.import.signals', $config['import']['signals']);

        return $config;
    }
}
