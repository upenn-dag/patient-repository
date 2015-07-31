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

use DAG\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
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

        // Prepend regimen prototype.
        $container->prependExtensionConfig('dag_prototype', array(
            'classes' => array(
                $this->applicationName.':'.'regimen' => array(
                    'subject'   => $config['classes']['regimen']['model'],
                    'prototype' => array(
                        'model' => 'Accard\Component\Regimen\Model\Prototype',
                        'repository' => 'DAG\Bundle\PrototypeBundle\Doctrine\ORM\PrototypeRepository',
                        'form' => 'Accard\Bundle\RegimenBundle\Form\Type\RegimenPrototypeType',
                    ),
                    'field' => array(
                        'model' => 'Accard\Component\Regimen\Model\Field',
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Regimen\Model\FieldValue',
                    ),
                )
            )));

        // Prepend regimen prototype field.
            $container->prependExtensionConfig('dag_field', array(
            'classes' => array(
                $this->applicationName.':'.'regimen_prototype' => array(
                    'subject'   => $config['classes']['regimen']['model'],
                    'field' => array(
                        'model' => 'Accard\Component\Regimen\Model\Field'
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Regimen\Model\FieldValue'
                    ),
                )
            )));
    }
}
