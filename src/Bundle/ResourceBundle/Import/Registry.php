<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Import;

use Symfony\Component\DependencyInjection\ContainerAware;
use Accard\Bundle\ResourceBundle\Exception\ImporterAccessException;
use Accard\Bundle\ResourceBundle\Exception\DuplicateImporterException;

/**
 * Importer registry.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Registry extends ContainerAware
{
    /**
     * Importers.
     *
     * @var array|ImporterInterface[]
     */
    protected $importers;


    /**
     * Constructor.
     *
     * @param array|ImporterInterface[] $importers
     */
    public function __construct(array $importers = array())
    {
        $this->importers = $importers;
    }

    /**
     * Get importers.
     *
     * @return array|ImporterInterface[]
     */
    public function getImporters()
    {
        foreach ($this->importers as $name => $service) {
            $this->primeImporter($name);
        }

        return $this->importers;
    }

    /**
     * Test for importer presence.
     *
     * @param string $name
     * @return boolean
     */
    public function hasImporter($name)
    {
        if (is_object($name)) {
            $name = $name->getName();
        }

        return isset($this->importers[$name]);
    }

    /**
     * Get importer by name.
     *
     * @throws ImporterAccessException If importer is not found.
     * @param string $name
     * @return ImporterInterface
     */
    public function getImporter($name)
    {
        $this->primeImporter($name);

        return $this->importers[$name];
    }

    /**
     * Get importer from service container.
     *
     * @param string $name
     */
    private function primeImporter($name)
    {
        if (!$this->hasImporter($name)) {
            throw new ImporterAccessException($name);
        }

        if (!$this->importers[$name] instanceof ImporterInterface) {
            $this->importers[$name] = $this->container->get($this->importers[$name]);
        }
    }

    /**
     * Register importer by name.
     *
     * @throws DuplicateImporterException If importer is already registered.
     * @param string $name
     * @param string $service
     */
    public function registerImporter($name, $service)
    {
        if ($this->hasImporter($name)) {
            throw new DuplicateImporterException($name);
        }

        $this->importers[$name] = $service;
    }

    /**
     * Unregister importer by name.
     *
     * @throws ImporterAccessException If importer is not found.
     * @param string $name
     */
    public function unregisterImporter($name)
    {
        if (!$this->hasImporter($name)) {
            throw new ImporterAccessException($name);
        }

        unset($this->importers[$name]);
    }
}
