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
 * Accard log model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface LogInterface
{
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get user.
     *
     * @return UserInterface
     */
    public function getUser();

    /**
     * Set user.
     *
     * @param UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user);

    /**
     * Get log date.
     *
     * @return DateTime
     */
    public function getLogDate();

    /**
     * Set log date.
     *
     * @param DateTime $logDate
     * @return self
     */
    public function setLogDate(DateTime $logDate);

    /**
     * Get action.
     *
     * @return string
     */
    public function getAction();

    /**
     * Set action.
     *
     * @param string $action
     * @return self
     */
    public function setAction($action);

    /**
     * Get resource name.
     *
     * @return string
     */
    public function getResource();

    /**
     * Set resource name.
     *
     * @param string $resource
     * @return string
     */
    public function setResource($resource);

    /**
     * Get resource id.
     *
     * @return integer|null
     */
    public function getResourceId();

    /**
     * Set resource id.
     *
     * @param integer|null $resourceId
     * @return self
     */
    public function setResourceId($resourceId = null);

    /**
     * Get route.
     *
     * @return string
     */
    public function getRoute();

    /**
     * Set route.
     *
     * @param string $route
     * @return self
     */
    public function setRoute($route);

    /**
     * Get attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Set attributes.
     *
     * @param array|null $attributes
     * @return self
     */
    public function setAttributes(array $attributes = null);

    /**
     * Get query (GET).
     *
     * @return array
     */
    public function getQuery();

    /**
     * Set query (GET).
     *
     * @param array|null $query
     * @return self
     */
    public function setQuery(array $query = null);

    /**
     * Get request (POST).
     *
     * @return array
     */
    public function getRequest();

    /**
     * Set request (POST).
     *
     * @param array|null $request
     * @return self
     */
    public function setRequest(array $request = null);
}
