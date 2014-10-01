<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ActivityBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Accard\Component\Activity\Builder\ActivityBuilderInterface;

/**
 * Activity builder listener.
 *
 * Responsible for adding default null objects to represent the values for each
 * activity field form element. This will ensure that the fields are present to
 * be filled on create forms where they haven't yet been included.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DefaultActivityFieldListener implements EventSubscriberInterface
{
    /**
     * Form factory.
     *
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * Activity builder.
     *
     * @var ActivityBuilderInterface
     */
    private $builder;


    /**
     * Constructor.
     *
     * @param FormFactoryInterface $factory
     * @param ActivityBuilderInterface $builder
     */
    public function __construct(FormFactoryInterface $factory, ActivityBuilderInterface $builder)
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
     * Create all activity fields not already set.
     *
     * @param FormEvent $event
     */
    public function buildForm(FormEvent $event)
    {
        if (null === ($activity = $event->getData())) {
            return;
        }

        if (null === $activity->getPrototype()) {
        	return;
        }

        $this->builder->set($activity);
        $possibleFields = $activity->getPrototype()->getFields();

        foreach ($possibleFields as $field) {
            if (!$activity->hasFieldByName($field->getName())) {
                $this->builder->addField($field->getName(), null, $field->getPresentation());
            }
        }
    }
}
