<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SampleBundle\DependencyInjection;

use Accard\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Accard sample bundle extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardSampleExtension extends AbstractResourceExtension implements PrependExtensionInterface
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

        if (!$container->hasExtension('accard_prototype') || !$container->hasExtension('accard_field')) {
            return;
        }

        // Prepend sample prototype.
        $container->prependExtensionConfig('accard_prototype', array(
            'classes' => array(
                'sample' => array(
                    'subject'   => $config['classes']['sample']['model'],
                    'prototype' => array(
                        'model' => 'Accard\Component\Sample\Model\Prototype',
                        'repository' => 'Accard\Bundle\PrototypeBundle\Doctrine\ORM\PrototypeRepository',
                    ),
                    'field' => array(
                        'model' => 'Accard\Component\Sample\Model\Field',
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Sample\Model\FieldValue',
                    ),
                )
            ))
        );

        // Prepend sample prototype field.
        $container->prependExtensionConfig('accard_field', array(
            'classes' => array(
                'sample_prototype' => array(
                    'subject'   => $config['classes']['sample']['model'],
                    'field' => array(
                        'model' => 'Accard\Component\Sample\Model\Field'
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Sample\Model\FieldValue'
                    ),
                )
            ))
        );
    }
}
