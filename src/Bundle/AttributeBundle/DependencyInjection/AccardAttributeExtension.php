<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\AttributeBundle\DependencyInjection;

use DAG\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * Accard attribute bundle extension.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class AccardAttributeExtension extends AbstractResourceExtension implements PrependExtensionInterface
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

        // Prepend attribute prototype.
        $container->prependExtensionConfig('accard_prototype', array(
            'classes' => array(
                'attribute' => array(
                    'subject'   => $config['classes']['attribute']['model'],
                    'prototype' => array(
                        'model' => 'Accard\Component\Attribute\Model\Prototype',
                        'repository' => 'DAG\Bundle\PrototypeBundle\Doctrine\ORM\PrototypeRepository',
                    ),
                    'field' => array(
                        'model' => 'Accard\Component\Attribute\Model\Field',
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Attribute\Model\FieldValue',
                    ),
                )
            ))
        );

        // Prepend attribute prototype field.
        $container->prependExtensionConfig('accard_field', array(
            'classes' => array(
                'attribute_prototype' => array(
                    'subject'   => $config['classes']['attribute']['model'],
                    'field' => array(
                        'model' => 'Accard\Component\Attribute\Model\Field'
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Attribute\Model\FieldValue'
                    ),
                )
            ))
        );
    }
}
