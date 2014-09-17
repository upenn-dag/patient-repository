<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Accard\Bundle\ResourceBundle\DependencyInjection\Driver;

use Accard\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DoctrineORMDriver extends AbstractDatabaseDriver
{
    /**
     * {@inheritdoc}
     */
    public function getSupportedDriver()
    {
        return AccardResourceBundle::DRIVER_DOCTRINE_ORM;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepositoryDefinition(array $classes)
    {
        $repositoryKey = $this->getContainerKey('repository', '.class');
        $repositoryClass = 'Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository';

        if ($this->container->hasParameter($repositoryKey)) {
            $repositoryClass = $this->container->getParameter($repositoryKey);
        }

        if (isset($classes['repository'])) {
            $repositoryClass = $classes['repository'];
        }

        $definition = new Definition($repositoryClass);
        $definition->setArguments(array(
            new Reference($this->getContainerKey('manager')),
            $this->getClassMetadataDefinition($classes['model'])
        ));

        return $definition;
    }

    /**
     * {@inheritdoc}
     */
    protected function getManagerServiceKey()
    {
        return 'doctrine.orm.entity_manager';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClassMetadataClassname()
    {
        return 'Doctrine\\ORM\\Mapping\\ClassMetadata';
    }
}
