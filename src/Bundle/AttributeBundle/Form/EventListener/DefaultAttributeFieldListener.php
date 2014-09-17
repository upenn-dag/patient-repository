<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\AttributeBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Accard\Component\Attribute\Builder\AttributeBuilderInterface;

/**
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DefaultAttributeFieldListener implements EventSubscriberInterface
{
    /**
     * Form factory.
     *
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * Attribute builder.
     *
     * @var AttributeBuilderInterface
     */
    private $builder;


    /**
     * Constructor.
     *
     * @param FormFactoryInterface $factory
     * @param AttributeBuilderInterface $builder
     */
    public function __construct(FormFactoryInterface $factory, AttributeBuilderInterface $builder)
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
     * Create all attribute fields not already set.
     *
     * @param FormEvent $event
     */
    public function buildForm(FormEvent $event)
    {
        if (null === ($attribute = $event->getData())) {
            return;
        }

    }
}
