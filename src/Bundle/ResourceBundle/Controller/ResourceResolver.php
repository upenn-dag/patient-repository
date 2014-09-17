<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Accard\Bundle\ResourceBundle\Controller;

use Accard\Component\Resource\Repository\RepositoryInterface;

/**
 * Resource resolver.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResourceResolver
{
    /**
     * @var Configuration
     */
    private $config;

    /**
     * Constructor.
     *
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * Get resources via repository based on the configuration.
     *
     * @param RepositoryInterface $repository
     * @param string $defaultMethod
     * @param array $defaultArguments
     *
     * @return mixed
     */
    public function getResource(RepositoryInterface $repository, $defaultMethod, array $defaultArguments = array())
    {
        $callable = array($repository, $this->config->getMethod($defaultMethod));
        $arguments = $this->config->getArguments($defaultArguments);

        return call_user_func_array($callable, $arguments);
    }

    /**
     * Create resource.
     *
     * @param RepositoryInterface $repository
     * @param string $defaultMethod
     * @param array $defaultArguments
     *
     * @return mixed
     */
    public function createResource(RepositoryInterface $repository, $defaultMethod, array $defaultArguments = array())
    {
        $callable = array($repository, $this->config->getFactoryMethod($defaultMethod));
        $arguments = $this->config->getFactoryArguments($defaultArguments);

        return call_user_func_array($callable, $arguments);
    }
}
