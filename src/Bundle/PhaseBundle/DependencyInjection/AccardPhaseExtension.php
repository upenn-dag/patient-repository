<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PhaseBundle\DependencyInjection;

use DAG\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Accard phase bundle extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardPhaseExtension extends AbstractResourceExtension
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
        $this->configure($config, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE);
    }
}
