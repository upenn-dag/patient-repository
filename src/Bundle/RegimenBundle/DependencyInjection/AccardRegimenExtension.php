<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\RegimenBundle\DependencyInjection;

use Accard\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Accard regimen bundle extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardRegimenExtension extends AbstractResourceExtension implements PrependExtensionInterface
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

        // Prepend regimen prototype.
        $container->prependExtensionConfig('accard_prototype', array(
            'classes' => array(
                'regimen' => array(
                    'subject'   => $config['classes']['regimen']['model'],
                    'prototype' => array(
                        'model' => 'Accard\Component\Regimen\Model\Prototype',
                        'repository' => 'Accard\Bundle\PrototypeBundle\Doctrine\ORM\PrototypeRepository',
                    ),
                    'field' => array(
                        'model' => 'Accard\Component\Regimen\Model\Field',
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Regimen\Model\FieldValue',
                    ),
                )
            ))
        );

        // Prepend regimen prototype field.
        $container->prependExtensionConfig('accard_field', array(
            'classes' => array(
                'regimen_prototype' => array(
                    'subject'   => $config['classes']['regimen']['model'],
                    'field' => array(
                        'model' => 'Accard\Component\Regimen\Model\Field'
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Regimen\Model\FieldValue'
                    ),
                )
            ))
        );
    }
}
