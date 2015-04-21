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

use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Resource\Model\UserInterface;
use Accard\Component\Resource\Model\Log;
use Accard\Component\Resource\Model\LogInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Accard resource action logger.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActionLogger
{
    /**
     * Controller configuration.
     *
     * @var Configuration
     */
    private $config;

    /**
     * Current user.
     *
     * @var UserInterface
     */
    private $user;

    /**
     * Object manager.
     *
     * @var ObjectManager
     */
    private $manager;

    /**
     * Constructor.
     *
     * @param Configuration $config
     */
    public function __construct(Configuration $config,
                                UserInterface $user,
                                ObjectManager $manager)
    {
        $this->config = $config;
        $this->user = $user;
        $this->manager = $manager;
    }

    /**
     * Log index actions.
     */
    public function indexLog()
    {
        $log = $this->prepareLog('index');

        return $this->persistLog($log);
    }

    /**
     * Log show actions.
     */
    public function showLog()
    {
        $log = $this->prepareLog('show');

        return $this->persistLog($log);
    }

    /**
     * Log new actions.
     */
    public function newLog()
    {
        $log = $this->prepareLog('new');

        return $this->persistLog($log);
    }

    /**
     * Log create actions.
     */
    public function createLog()
    {
        $log = $this->prepareLog('create');

        return $this->persistLog($log);
    }

    /**
     * Log edit actions.
     */
    public function editLog()
    {
        $log = $this->prepareLog('edit');

        return $this->persistLog($log);
    }

    /**
     * Log update actions.
     */
    public function updateLog()
    {
        $log = $this->prepareLog('update');

        return $this->persistLog($log);
    }

    /**
     * Log delete actions.
     */
    public function deleteLog()
    {
        $log = $this->prepareLog('delete');

        return $this->persistLog($log);
    }

    /**
     * Persist a new log object.
     *
     * Wraps call in a transaction so it does not mess with any other controller
     * functionality or database calls.
     *
     * @param LogInterface $log
     * @return LogInterface
     */
    private function persistLog(LogInterface $log)
    {
        $this->manager->transactional(function($em) use ($log) {
            $em->persist($log);
        });

        return $log;
    }

    /**
     * Prepare a new log object.
     *
     * Grabs data from the request and elsewhere to construct a new log object
     * from controller data.
     *
     * @param string $action
     * @return LogInterface
     */
    private function prepareLog($action)
    {
        $request = $this->config->getRequest();
        $method = strtolower($request->getMethod());
        $attributes = $this->prepareAttributes($request->attributes);
        $query = $request->query->all();
        $post = $request->request->all();
        extract($attributes); // $route, $params, $id

        $log = new Log();
        $log
            ->setUser($this->user)
            ->setAction($action)
            ->setResource($this->config->getResourceName())
            ->setResourceId($id)
            ->setRoute($route)
            ->setAttributes($params)
            ->setQuery($query ? $query : null)
            ->setRequest($post ? $post : null)
        ;

        return $log;
    }

    /**
     * Prepare request attributes for saving.
     *
     * @param ParameterBag $attribtues
     * @return array
     */
    private function prepareAttributes(ParameterBag $attributes)
    {
        $params = $attributes->get('_route_params');
        unset($params['_accard']);

        $attrs = array(
            'route'  => $attributes->get('_route'),
            'params' => $params ? $params : null,
            'id'     => $attributes->get('id'),
        );

        return $attrs;
    }
}
