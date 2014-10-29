<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\ExpressionLanguage;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Abstract, container aware expression language extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class ContainerAwareExtension implements ContainerAwareInterface, ExtensionInterface
{
    /**
     * Service container.
     *
     * @var ContainerInterface
     */
    protected $container;


    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
