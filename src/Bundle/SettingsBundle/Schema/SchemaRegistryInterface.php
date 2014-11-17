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

/**
 * Schema registry interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SchemaRegistryInterface
{
    /**
     * Get schemas.
     *
     * @return SchemaInterface[]
     */
    public function getSchemas();

    /**
     * Register a schema within a namespace.
     *
     * @param string $namespace
     * @param SchemaInterface $schema
     */
    public function registerSchema($namespace, SchemaInterface $schema);

    /**
     * Unregister a schema within a namespace.
     *
     * @param string $namespace
     */
    public function unregisterSchema($namespace);

    /**
     * Test for presence of a schema within a namespace.
     *
     * @param string $namespace
     * @return boolean
     */
    public function hasSchema($namespace);

    /**
     * Get schema within a namespace.
     *
     * @param string $namespace
     * @return SchemaRegistryInterface
     */
    public function getSchema($namespace);

    /**
     * Register a schema extension within a namespace.
     *
     * @param string $namespace
     * @param SchemaExtensionInterface $extension
     */
    public function registerExtension($namespace, SchemaExtensionInterface $extension);

    /**
     * Unregister a schema extension within a namespace.
     *
     * @param string $namespace
     * @param SchemaExtensionInterface $extension
     */
    public function unregisterExtension($namespace, SchemaExtensionInterface $extension);

    /**
     * Get extensions for a namespace.
     *
     * @param string $namespace
     * @return SchemaExtensionInterface[]
     */
    public function getExtensions($namespace);
}
