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

use Doctrine\Common\Collections\Collection;

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
     * @return Collection|SchemaInterface[]
     */
    public function getSchemas();

    /**
     * Register a schema within a namespace.
     *
     * @param string $namespace
     * @param SchemaInterface $schema
     * @return SchemaRegistryInterface
     */
    public function registerSchema($namespace, SchemaInterface $schema);

    /**
     * Unregister a schema within a namespace.
     *
     * @param string $namespace
     * @return SchemaRegistryInterface
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
}
