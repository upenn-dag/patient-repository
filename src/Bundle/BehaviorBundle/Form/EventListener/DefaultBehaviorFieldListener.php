<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\BehaviorBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Accard\Component\Behavior\Builder\BehaviorBuilderInterface;

/**
 *
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DefaultBehaviorFieldListener implements EventSubscriberInterface
{
    /**
     * Form factory.
     *
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * Behavior builder.
     *
     * @var BehaviorBuilderInterface
     */
    private $builder;


    /**
     * Constructor.
     *
     * @param FormFactoryInterface $factory
     * @param BehaviorBuilderInterface $builder
     */
    public function __construct(FormFactoryInterface $factory, BehaviorBuilderInterface $builder)
    {
        $this->factory = $factory;
        $this->builder = $builder;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'buildForm');
    }

    /**
     * Create all behavior fields not already set.
     *
     * @param FormEvent $event
     */
    public function buildForm(FormEvent $event)
    {
        if (null === ($behavior = $event->getData())) {
            return;
        }

    }
}
