<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ActivityBundle\DependencyInjection;

use Accard\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Accard activity bundle extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardActivityExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
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

        $this->prependPrototype($container, $config);
    }

    /**
     * Prepend activity prototype and field definitions.
     *
     * @param ContainerBuilder $container
     * @param array $config
     */
    private function prependPrototype(ContainerBuilder $container, array $config)
    {
        if (!$container->hasExtension('accard_prototype') || !$container->hasExtension('accard_field')) {
            return;
        }

        // Prepend activity prototype.
        $container->prependExtensionConfig('accard_prototype', array(
            'classes' => array(
                'activity' => array(
                    'subject'   => $config['classes']['activity']['model'],
                    'prototype' => array(
                        'model' => 'Accard\Component\Activity\Model\Prototype'
                    ),
                    'field' => array(
                        'model' => 'Accard\Component\Activity\Model\Field',
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Activity\Model\FieldValue',
                    ),
                )
            ))
        );

        // Prepend activity prototype field.
        $container->prependExtensionConfig('accard_field', array(
            'classes' => array(
                'activity_prototype' => array(
                    'subject'   => $config['classes']['activity']['model'],
                    'field' => array(
                        'model' => 'Accard\Component\Activity\Model\Field'
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Activity\Model\FieldValue'
                    ),
                )
            ))
        );
    }
}
