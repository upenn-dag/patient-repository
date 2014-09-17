<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PrototypeBundle\DependencyInjection;

use Accard\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Accard\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Accard prototype bundle extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardPrototypeExtension extends AbstractResourceExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configure($config, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS | self::CONFIGURE_VALIDATORS);
    }

    /**
     * {@inheritdoc}
     */
    public function process(array $config, ContainerBuilder $container)
    {
        $convertedConfig = array();
        $subjects = array();

        foreach ($config['classes'] as $subject => $parameters) {
            $subjects[$subject] = $parameters;
            unset($parameters['subject']);

            foreach ($parameters as $resource => $classes) {
                $convertedConfig[$subject.'_'.$resource] = $classes;
            }

            $this->createSubjectServices($container, $config['driver'], $subject, $convertedConfig);

            if (!isset($config['validation_groups'][$subject]['prototype'])) {
                $config['validation_groups'][$subject]['prototype'] = array('accard');
            }
        }

        $container->setParameter('accard.prototype.subjects', $subjects);

        $config['classes'] = $convertedConfig;
        $convertedConfig = array();

        foreach ($config['validation_groups'] as $subject => $parameters) {
            foreach ($parameters as $resource => $validationGroups) {
                $convertedConfig[$subject.'_'.$resource] = $validationGroups;
            }
        }

        $config['validation_groups'] = $convertedConfig;

        return $config;
    }

    /**
     * Create services for every subject.
     *
     * @param ContainerBuilder $container
     * @param string           $driver
     * @param string           $subject
     * @param array            $config
     */
    private function createSubjectServices(ContainerBuilder $container, $driver, $subject, array $config)
    {
        $prototypeAlias = $subject.'_prototype';
        $prototypeClasses = $config[$prototypeAlias];

        $prototypeFormType = new Definition($prototypeClasses['form']);
        $prototypeFormType
            ->setArguments(array($subject, $prototypeClasses['model'], '%accard.validation_group.'.$prototypeAlias.'%'))
            ->addTag('form.type', array('alias' => 'accard_'.$prototypeAlias))
        ;

        $container->setDefinition('accard.form.type.'.$prototypeAlias, $prototypeFormType);
    }
}
