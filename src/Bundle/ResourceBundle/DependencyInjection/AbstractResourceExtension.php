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

use Accard\Bundle\ResourceBundle\DependencyInjection\Driver\DatabaseDriverFactory;
use Accard\Bundle\ResourceBundle\Exception\Driver\InvalidDriverException;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Base extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class AbstractResourceExtension extends Extension
{
    const CONFIGURE_LOADER     = 1;
    const CONFIGURE_DATABASE   = 2;
    const CONFIGURE_PARAMETERS = 4;
    const CONFIGURE_VALIDATORS = 8;

    protected $applicationName = 'accard';
    protected $configDirectory = '/../Resources/config';
    protected $configFiles = array('services');

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configure($config, new Configuration(), $container);
    }

    /**
     * @param array                  $config
     * @param ConfigurationInterface $configuration
     * @param ContainerBuilder       $container
     * @param integer                $configure
     *
     * @return array
     */
    public function configure(
        array $config,
        ConfigurationInterface $configuration,
        ContainerBuilder $container,
        $configure = self::CONFIGURE_LOADER
    ) {
        $processor = new Processor();
        $config    = $processor->processConfiguration($configuration, $config);

        $config = $this->process($config, $container);

        $loader = new YamlFileLoader($container, new FileLocator($this->getConfigurationDirectory()));

        $this->loadConfigurationFile($this->configFiles, $loader);

        if ($configure & self::CONFIGURE_DATABASE) {
            $this->loadDatabaseDriver($config, $loader, $container);
        }

        $classes = isset($config['classes']) ? $config['classes'] : array();

        if ($configure & self::CONFIGURE_PARAMETERS) {
            $this->mapClassParameters($classes, $container);
            $this->mapInheritance($classes, $container);
        }

        if ($configure & self::CONFIGURE_VALIDATORS) {
            $this->mapValidationGroupParameters($config['validation_groups'], $container);
        }

        if ($container->hasParameter('accard.config.classes')) {
            $classes = array_merge($classes, $container->getParameter('accard.config.classes'));
        }

        $container->setParameter('accard.config.classes', $classes);

        if (!$container->hasParameter('accard.config.inheritance')) {
            $container->setParameter('accard.config.inheritance', array());
        }

        return array($config, $loader);
    }

    protected function mapInheritance(array $classes, ContainerBuilder $container)
    {
        foreach ($classes as $model => $inheritanceClass) {
            if (isset($inheritanceClass['children'])) {
                $map = array();//array($model => $inheritanceClass['model']);
                foreach ($inheritanceClass['children'] as $child) {
                    $map[$child] = $classes[$child]['model'];
                }

                $inherited = array();
                if ($container->hasParameter('accard.config.inheritance')) {
                    $inherited = $container->getParameter('accard.config.inheritance');
                }

                $inherited[$model] = $map;
                $container->setParameter('accard.config.inheritance', $inherited);
            }
        }
    }

    /**
     * Remap class parameters.
     *
     * @param array            $classes
     * @param ContainerBuilder $container
     */
    protected function mapClassParameters(array $classes, ContainerBuilder $container)
    {
        foreach ($classes as $model => $serviceClasses) {
            foreach ($serviceClasses as $service => $class) {
                $container->setParameter(
                    sprintf(
                        '%s.%s.%s.class',
                        $this->applicationName,
                        $service === 'form' ? 'form.type' : $service,
                        $model
                    ),
                    $class
                );
            }
        }
    }

    /**
     * Remap validation group parameters.
     *
     * @param array            $validationGroups
     * @param ContainerBuilder $container
     */
    protected function mapValidationGroupParameters(array $validationGroups, ContainerBuilder $container)
    {
        foreach ($validationGroups as $model => $groups) {
            $container->setParameter(sprintf('%s.validation_group.%s', $this->applicationName, $model), $groups);
        }
    }

    /**
     * Load bundle driver.
     *
     * @param array                 $config
     * @param YamlFileLoader         $loader
     * @param null|ContainerBuilder $container
     *
     * @throws InvalidDriverException
     */
    protected function loadDatabaseDriver(array $config, YamlFileLoader $loader, ContainerBuilder $container)
    {
        $bundle = str_replace(array('Extension', 'DependencyInjection\\'), array('Bundle', ''), get_class($this));
        $driver = $config['driver'];

        $this->loadConfigurationFile(array(sprintf('driver/%s', $driver)), $loader);

        $container->setParameter($this->getAlias().'.driver', $driver);
        $container->setParameter($this->getAlias().'.driver.'.$driver, true);

        foreach ($config['classes'] as $model => $classes) {
            if (array_key_exists('model', $classes)) {
                DatabaseDriverFactory::get(
                    $driver,
                    $container,
                    $this->applicationName,
                    $model
                )->load($classes);
            }
        }
    }

    /**
     * @param array         $config
     * @param YamlFileLoader $loader
     */
    protected function loadConfigurationFile(array $config, YamlFileLoader $loader)
    {
        foreach ($config as $filename) {
            if (file_exists($file = sprintf('%s/%s.yml', $this->getConfigurationDirectory(), $filename))) {
                $loader->load($file);
            }
        }
    }

    /**
     * Get the configuration directory
     *
     * @return string
     * @throws \RuntimeException
     */
    protected function getConfigurationDirectory()
    {
        $reflector = new \ReflectionClass($this);
        $fileName = $reflector->getFileName();

        if (!is_dir($directory = dirname($fileName) . $this->configDirectory)) {
            throw new \RuntimeException(sprintf('The configuration directory "%s" does not exists.', $directory));
        }

        return $directory;
    }

    /**
     * In case any extra processing is needed.
     *
     * @param array            $config
     * @param ContainerBuilder $container
     *
     * @return array
     */
    protected function process(array $config, ContainerBuilder $container)
    {
        // Override if needed.
        return $config;
    }
}
