<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Prototype\Provider;

use Accard\Component\Prototype\Repository\PrototypeRepositoryInterface;
use Accard\Component\Prototype\Exception\PrototypeNotFoundException;

/**
 * Prototype provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PrototypeProvider implements PrototypeProviderInterface
{
    /**
     * Repository.
     *
     * @var PrototypeRepositoryInterface
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param PrototypeRepositoryInterface $repository
     */
    public function __construct(PrototypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrototypes()
    {
        return $this->repository->getPrototypes();
    }

    /**
     * {@inheritdoc}
     */
    public function getPrototypeModelClass()
    {
        return $this->repository->getClassName();
    }

    /**
     * {@inheritdoc}
     */
    public function hasPrototype($prototypeId)
    {
        try {
            $this->getPrototype($prototypeId);

            return true;
        } catch (PrototypeNotFoundException $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPrototype($prototypeId)
    {
        if (!$prototype = $this->repository->getPrototype($prototypeId)) {
            throw new PrototypeNotFoundException($prototypeId);
        }

        return $prototype;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPrototypeByName($prototypeName)
    {
        try {
            $this->getPrototypeByName($prototypeName);

            return true;
        } catch (PrototypeNotFoundException $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPrototypeByName($prototypeName)
    {
        if (!$prototype = $this->repository->getPrototypeByName($prototypeName)) {
            throw new PrototypeNotFoundException($prototypeName);
        }

        return $prototype;
    }
}
