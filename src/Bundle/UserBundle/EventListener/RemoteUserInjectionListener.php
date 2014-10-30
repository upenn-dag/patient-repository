<?php

/**
 * This file is part of Accard.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Accard\Bundle\UserBundle\EventListener;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Injects a username value read from parameters.yml into the
 * $_SERVER['REMOTE_USER'], effectively faking a valid CoSign session for the
 * purposes of testing application code locally.
 *
 * @author Michael Woods <woodsm@mail.med.upenn.edu>
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RemoteUserInjectionListener
{
    /**
     * Application kernel.
     *
     * @var KernelInterface
     */
    private $appKernel;

    /**
     * Service container.
     *
     * @var ContainerInterface
     */
    private $container;


    /**
     * Constructor
     *
     * @param KernelInterface $kernel
     * @param ContainerInterface $container
     */
    public function __construct(KernelInterface $appKernel, ContainerInterface $container)
    {
        $this->appKernel = $appKernel;
        $this->container = $container;
    }

    /**
     * Kernel request listener.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ("dev" === $this->appKernel->getEnvironment() && $event->isMasterRequest()) {
            $request = $event->getRequest();

            if ($request->server->has("REMOTE_USER")) {
                return;
            }

            $username = $this->container->getParameter("accard.user.remote_username");

            if (empty($username)) {
                throw new \RuntimeException(
                    "The 'remote_user' variable must be set in parameters.yml in dev"
                );
            }

            $request->server->add(array("REMOTE_USER" => $username));
        }
    }
}
