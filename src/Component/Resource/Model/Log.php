<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Model;

use DateTime;

/**
 * Accard log model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Log implements LogInterface
{
    /**
     * Log id.
     *
     * @var string
     */
    protected $id;

    /**
     * User.
     *
     * @var string
     */
    protected $user;

    /**
     * Log date.
     *
     * @var string
     */
    protected $logDate;

    /**
     * Action.
     *
     * @var string
     */
    protected $action;

    /**
     * Resource.
     *
     * @var string
     */
    protected $resource;

    /**
     * Resource id.
     *
     * @var string
     */
    protected $resourceId;

    /**
     * Route.
     *
     * @var string
     */
    protected $route;

    /**
     * Attributes.
     *
     * @var string
     */
    protected $attributes;

    /**
     * Query (GET).
     *
     * @var string
     */
    protected $query;

    /**
     * Request (POST).
     *
     * @var string
     */
    protected $request;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->logDate = new DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDate()
    {
        return $this->logDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogDate(DateTime $logDate)
    {
        $this->logDate = $logDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * {@inheritdoc}
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * {@inheritdoc}
     */
    public function setResourceId($resourceId = null)
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * {@inheritdoc}
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributes(array $attributes = null)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuery(array $query = null)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function setRequest(array $request = null)
    {
        $this->request = $request;

        return $this;
    }
}
