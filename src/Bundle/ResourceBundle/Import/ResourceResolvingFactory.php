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
use Accard\Bundle\ResourceBundle\Exception\ResourceObjectNotFoundException;

/**
 * Resource resolver.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResourceResolvingFactory extends ContainerAware
{
    /**
     * Resolve resource.
     *
     * @param string $resource
     * @param integer $resourceType
     * @return ResourceInterface
     */
    public function resolveResource($resource, $resourceType)
    {
        $manager = $this->getManagerForResource($resource);
        $repository = $this->getRepositoryForResource($resource);
        $form = $this->getFormForResource($resource);

        return new Resource($resource, $manager, $repository, $resourceType, $form);
    }

    /**
     * Resolve subject.
     *
     * @param string $resource
     * @return ResourceInterface
     */
    public function resolveSubject($resource)
    {
        return $this->resolveResource($resource, ResourceInterface::SUBJECT);
    }

    /**
     * Resolve target.
     *
     * @param string $resource
     * @return ResourceInterface
     */
    public function resolveTarget($resource)
    {
        return $this->resolveResource("import_{$resource}", ResourceInterface::TARGET);
    }

    /**
     * Get resource manager.
     *
     * @param string $resource
     * @return ObjectManager
     */
    private function getManagerForResource($resource)
    {
        $pattern = sprintf('accard.manager.%s', $resource);

        if (!$this->container->has($pattern)) {
            throw new ResourceObjectNotFoundException($pattern);
        }

        return $this->container->get($pattern);
    }

    /**
     * Get resource repository.
     *
     * @param string $resource
     * @return ObjectRepository
     */
    private function getRepositoryForResource($resource)
    {
        $pattern = sprintf('accard.repository.%s', $resource);

        if (!$this->container->has($pattern)) {
            throw new ResourceObjectNotFoundException($pattern);
        }

        return $this->container->get($pattern);
    }

    /**
     * Get resource form.
     *
     * @param string $resource
     * @return FormTypeInterface
     */
    private function getFormForResource($resource)
    {
        $pattern = sprintf('accard.form.type.%s', $resource);

        if ($this->container->has($pattern)) {
            return $this->container->get($pattern);
        }
    }
}
