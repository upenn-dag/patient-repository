<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle\DependencyInjection;

use DAG\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * Accard Diagnosis bundle extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class AccardDiagnosisExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    protected $applicationName = 'accard';

    /**
     * {@inheritdoc}
     */
    protected $configFiles = array('services', 'builders', 'forms', 'providers');

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

        $this->prependField($container, $config);
    }

    private function prependField(ContainerBuilder $container, array $config)
    {
        if (!$container->hasExtension('dag_field')) {
            return;
        }

        $container->prependExtensionConfig('dag_field', array(
            'classes' => array(
                $this->applicationName.':'.'diagnosis' => array(
                    'subject'   => $config['classes']['diagnosis']['model'],
                    'field' => array(
                        'model' => 'Accard\Component\Diagnosis\Model\Field'
                    ),
                    'field_value' => array(
                        'model' => 'Accard\Component\Diagnosis\Model\FieldValue'
                    ),
                )
            ))
        );
    }
}
