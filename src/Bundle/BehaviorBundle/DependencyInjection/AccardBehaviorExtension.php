<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\BehaviorBundle\DependencyInjection;

use DAG\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Accard behavior bundle extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardBehaviorExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    protected $applicationName = 'accard';

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
    public function prepend(ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $container->getExtensionConfig($this->getAlias()));

        if (!$container->hasExtension('dag_prototype') || !$container->hasExtension('dag_field')) {
            return;
        }

        // Prepend behavior prototype.
        $container->prependExtensionConfig('dag_prototype', array(
            'classes' => array(
                $this->applicationName.':'.'behavior' => array(
                    'subject'   => $config['classes']['behavior']['model'],
                    'prototype' => array(
                        'model' => 'Accard\Component\Behavior\Model\Prototype',
                        'repository' => 'DAG\Bundle\PrototypeBundle\Doctrine\ORM\PrototypeRepository',
                    ),
                    'field' => array(
                        'model' => 'Accard\Component\Behavior\Model\Field',
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Behavior\Model\FieldValue',
                    ),
                )
            )));

        // Prepend behavior prototype field.
            $container->prependExtensionConfig('dag_field', array(
            'classes' => array(
                $this->applicationName.':'.'behavior_prototype' => array(
                    'subject'   => $config['classes']['behavior']['model'],
                    'field' => array(
                        'model' => 'Accard\Component\Behavior\Model\Field'
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Behavior\Model\FieldValue'
                    ),
                )
            )));
    }
}
