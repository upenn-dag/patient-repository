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
use Accard\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Domain manager.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DomainManager
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var FlashHelper
     */
    private $flashHelper;

    /**
     * @var Configuration
     */
    private $config;

    public function __construct(
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        FlashHelper $flashHelper,
        Configuration $config
    ) {
        $this->manager = $manager;
        $this->eventDispatcher = $eventDispatcher;
        $this->flashHelper = $flashHelper;
        $this->config = $config;
    }

    /**
     * @param object $resource
     *
     * @return object|null
     */
    public function create($resource)
    {
        /** @var ResourceEvent $event */
        $event = $this->dispatchEvent('pre_create', new ResourceEvent($resource, array('objectManager' => $this->manager)));

        if ($event->isStopped()) {
            $this->flashHelper->setFlash(
                $event->getMessageType(),
                $event->getMessage(),
                $event->getMessageParameters()
            );

            return null;
        }

        $this->manager->persist($resource);
        $this->manager->flush();
        $this->flashHelper->setFlash('success', 'create');

        $this->dispatchEvent('post_create', new ResourceEvent($resource, array('objectManager' => $this->manager)));

        return $resource;
    }

    /**
     * @param object $resource
     * @param string $flash
     *
     * @return object|null
     */
    public function update($resource, $flash = 'update')
    {
        /** @var ResourceEvent $event */
        $event = $this->dispatchEvent('pre_update', new ResourceEvent($resource, array('objectManager' => $this->manager)));

        if ($event->isStopped()) {
            $this->flashHelper->setFlash(
                $event->getMessageType(),
                $event->getMessage(),
                $event->getMessageParameters()
            );

            return null;
        }

        $this->manager->persist($resource);
        $this->manager->flush();
        $this->flashHelper->setFlash('success', $flash);

        $this->dispatchEvent('post_update', new ResourceEvent($resource, array('objectManager' => $this->manager)));

        return $resource;
    }

    public function move($resource, $movement)
    {
        $position = $this->config->getSortablePosition();

        $accessor = PropertyAccess::createPropertyAccessor();

        $accessor->setValue(
            $resource,
            $position,
            $accessor->getValue($resource, $position) + $movement
        );

        return $this->update($resource, 'move');
    }

    /**
     * @param object $resource
     *
     * @return object|null
     */
    public function delete($resource)
    {
        /** @var ResourceEvent $event */
        $event = $this->dispatchEvent('pre_delete', new ResourceEvent($resource, array('objectManager' => $this->manager)));

        if ($event->isStopped()) {
            $this->flashHelper->setFlash(
                $event->getMessageType(),
                $event->getMessage(),
                $event->getMessageParameters()
            );

            return null;
        }

        $fixedResource = clone $resource;
        $this->manager->remove($resource);
        $this->manager->flush();
        $this->flashHelper->setFlash('success', 'delete');

        $this->dispatchEvent('post_delete', new ResourceEvent($resource, array('objectManager' => $this->manager)));


        return $fixedResource;
    }

    /**
     * @param string $name
     * @param Event  $event
     *
     * @return Event
     */
    public function dispatchEvent($name, Event $event)
    {
        $name = $this->config->getEventName($name);

        return $this->eventDispatcher->dispatch($name, $event);
    }
}
