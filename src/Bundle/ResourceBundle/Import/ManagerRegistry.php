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
use Accard\Bundle\ResourceBundle\Exception\ManagerAccessException;
use Accard\Bundle\ResourceBundle\Exception\DuplicateManagerException;

/**
 * Importer Manager registry.
 *
 * @todo make a factory or some pattern that resolves the importer registry and this one
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class ManagerRegistry extends ContainerAware
{
    /**
     * Managers.
     *
     * @var array|ManagerInterface[]
     */
    protected $managers;


    /**
     * Constructor.
     *
     * @param array|ManagerInterface[] $managers
     */
    public function __construct(array $managers = array())
    {
        $this->managers = $managers;
    }

    /**
     * Get managers.
     *
     * @return array|ManagerInterface[]
     */
    public function getManagers()
    {
        foreach ($this->managers as $name => $service) {
            $this->primeManager($name);
        }

        return $this->managers;
    }

    /**
     * Test for manager presence.
     *
     * @param string $name
     * @return boolean
     */
    public function hasManager($name)
    {
        if (is_object($name)) {
            $name = $name->getName();
        }

        return isset($this->managers[$name]);
    }

    /**
     * Get manager by name.
     *
     * @throws ManagerAccessException If manager is not found.
     * @param string $name
     * @return ManagerInterface
     */
    public function getManager($name)
    {
        $this->primeManager($name);

        return $this->managers[$name];
    }

    /**
     * Get manager from service container.
     *
     * @param string $name
     */
    private function primeManager($name)
    {
        if (!$this->hasManager($name)) {
            throw new ManagerAccessException($name);
        }

        if (!$this->managers[$name] instanceof ManagerInterface) {
            $this->managers[$name] = $this->container->get($this->managers[$name]);
        }
    }

    /**
     * Register manager by name.
     *
     * @throws DuplicateManagerException If manager is already registered.
     * @param string $name
     * @param string $service
     */
    public function registerManager($name, $service)
    {
        if ($this->hasManager($name)) {
            throw new DuplicateManagerException($name);
        }

        $this->managers[$name] = $service;
    }

    /**
     * Unregister manager by name.
     *
     * @throws ManagerAccessException If manager is not found.
     * @param string $name
     */
    public function unregisterManager($name)
    {
        if (!$this->hasManager($name)) {
            throw new ManagerAccessException($name);
        }

        unset($this->managers[$name]);
    }
}
