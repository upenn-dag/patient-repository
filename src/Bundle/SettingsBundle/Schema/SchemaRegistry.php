<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SettingsBundle\Schema;

use Accard\Bundle\SettingsBundle\Exception\SchemaAccessException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Basic schema registry.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SchemaRegistry implements SchemaRegistryInterface
{
    /**
     * Schema collection.
     *
     * @var SchemaInterface[]
     */
    private $schemas;

    /**
     * Schema extension collection.
     *
     * @var SchemaExtensionInterface[]
     */
    private $extensions;

    /**
     * Service container.
     *
     * @var ContainerInterface
     */
    private $container;


    /**
     * Constructor.
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->schemas = array();
        $this->extensions = array();
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemas()
    {
        return $this->schemas;
    }

    /**
     * {@inheritdoc}
     */
    public function registerSchema($namespace, SchemaInterface $schema)
    {
        if ($this->hasSchema($namespace)) {
            throw new SchemaAccessException($namespace);
        }

        $this->schemas[$namespace] = $schema;
        $this->extensions[$namespace] = array();
    }

    /**
     * {@inheritdoc}
     */
    public function unregisterSchema($namespace)
    {
        if (!$this->hasSchema($namespace)) {
            throw new SchemaAccessException($namespace);
        }

        unset($this->schemas[$namespace], $this->extensions[$namespace]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasSchema($namespace)
    {
        return isset($this->schemas[$namespace]);
    }

    /**
     * {@inheritdoc}
     */
    public function getSchema($namespace)
    {
        if (!$this->hasSchema($namespace)) {
            throw new SchemaAccessException($namespace);
        }

        if ($this->container && $this->schemas[$namespace] instanceof ContainerAwareInterface) {
            $this->schemas[$namespace]->setContainer($this->container);
        }

        return $this->schemas[$namespace];
    }

    /**
     * {@inheritdoc}
     */
    public function registerExtension($namespace, SchemaExtensionInterface $extension)
    {
        if (!$this->hasSchema($namespace)) {
            throw new SchemaAccessException($namespace);
        }

        $this->extensions[$namespace][] = $extension;
    }

    /**
     * {@inheritdoc}
     */
    public function unregisterExtension($namespace, SchemaExtensionInterface $extension)
    {
        if (!$this->hasSchema($namespace)) {
            throw new SchemaAccessException($namespace);
        }

        if (false === ($key = array_search($extension, $this->extensions[$namespace]))) {
            throw new SchemaAccessException($namespace);
        }

        unset($this->extensions[$namespace][$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensions($namespace)
    {
        if (!$this->hasSchema($namespace)) {
            throw new SchemaAccessException($namespace);
        }

        $extensions = $this->extensions[$namespace];
        foreach ($extensions as $extension) {
            if ($this->container && $extension instanceof ContainerAwareInterface) {
                $extension->setContainer($this->container);
            }
        }

        return $extensions;
    }
}
