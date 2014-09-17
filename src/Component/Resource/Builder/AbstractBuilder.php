<?php


/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Builder;

use BadMethodCallException;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Resource\Repository\RepositoryInterface;
use Accard\Component\Resource\Exception\InvalidResourceException;

/**
 * Abstract resource builder.
 *
 * Common functionality for builders. Extending this class requires that you
 * inject an object manager before working with the builder resource.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class AbstractBuilder implements BuilderInterface
{
    /**
     * Builder resource.
     *
     * @var object
     */
    protected $resource;

    /**
     * Object manager.
     *
     * @var ObjectManager
     */
    protected $manager;


    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function set($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save($flush = true)
    {
        $this->manager->persist($this->resource);

        if ($flush) {
            $this->manager->flush();
        }

        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $arguments)
    {
        if (!method_exists($this->resource, $method)) {
            throw new BadMethodCallException(sprintf('Resource has no "%s()" method.', $method));
        }

        call_user_func_array(array($this->resource, $method), $arguments);

        return $this;
    }
}
