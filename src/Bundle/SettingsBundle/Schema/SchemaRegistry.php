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
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Bundle\SettingsBundle\Exception\SchemaAccessException;

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
     * @var Collection|SchemaInterface[]
     */
    protected $schemas;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->schemas = new ArrayCollection();
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
    }

    /**
     * {@inheritdoc}
     */
    public function unregisterSchema($namespace)
    {
        if (!$this->hasSchema($namespace)) {
            throw new SchemaAccessException($namespace);
        }

        $this->schemas->remove($namespace);
    }

    /**
     * {@inheritdoc}
     */
    public function hasSchema($namespace)
    {
        return $this->schemas->containsKey($namespace);
    }

    /**
     * {@inheritdoc}
     */
    public function getSchema($namespace)
    {
        if (!$this->hasSchema($namespace)) {
            throw new SchemaAccessException($namespace);
        }

        return $this->schemas[$namespace];
    }
}
