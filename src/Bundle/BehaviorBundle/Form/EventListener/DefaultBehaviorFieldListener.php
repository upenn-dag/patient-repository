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
 * Behavior builder listener.
 *
 * Responsible for adding default null objects to represent the values for each
 * behavior field form element. This will ensure that the fields are present to
 * be filled on create forms where they haven't yet been included.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
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
        return array(
            FormEvents::POST_SET_DATA => 'hidePrototype',
            FormEvents::PRE_SET_DATA => 'createFields',
        );
    }

    /**
     * Remove prototype field if prototype is present.
     *
     * @param FormEvent $event
     */
    public function hidePrototype(FormEvent $event)
    {
        if (!$this->testForPrototype($event)) {
            return;
        }

        if ($event->getForm()->has('prototype')) {
            $event->getForm()->remove('prototype');
        }
    }

    /**
     * Create all behavior fields not already set.
     *
     * @param FormEvent $event
     */
    public function createFields(FormEvent $event)
    {
        if (!$this->testForPrototype($event)) {
            return;
        }

        $behavior = $event->getData();
        $this->builder->set($behavior);
        $possibleFields = $behavior->getPrototype()->getFields();

        foreach ($possibleFields as $field) {
            if (!$behavior->hasFieldByName($field->getName())) {
                $this->builder->addField($field->getName(), null, $field->getPresentation());
            }
        }
    }

    /**
     * Test if prototype exists within form data.
     *
     * @return boolean
     */
    private function testForPrototype(FormEvent $event)
    {
        return !(null === ($behavior = $event->getData()) || null === $behavior->getPrototype());
    }
}
