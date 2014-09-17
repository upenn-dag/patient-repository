<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PatientBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Accard\Component\Patient\Builder\PatientBuilderInterface;

/**
 * Patient builder listener.
 *
 * Responsible for adding default null objects to represent the values for each
 * patient field form element. This will ensure that the fields are present to be
 * filled on create forms where they haven't yet been included.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DefaultPatientFieldListener implements EventSubscriberInterface
{
    /**
     * Form factory.
     *
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * Patient builder.
     *
     * @var PatientBuilderInterface
     */
    private $builder;


    /**
     * Constructor.
     *
     * @param FormFactoryInterface $factory
     * @param PatientBuilderInterface $builder
     */
    public function __construct(FormFactoryInterface $factory, PatientBuilderInterface $builder)
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
     * Create all patient fields not already set.
     *
     * @param FormEvent $event
     */
    public function buildForm(FormEvent $event)
    {
        if (null === ($patient = $event->getData())) {
            return;
        }

        $this->builder->set($patient);
        $possibleFields = $this->builder->getFieldRepository()->findAll();

        foreach ($possibleFields as $field) {
            if (!$patient->hasFieldByName($field->getName())) {
                $this->builder->addField($field->getName(), null, $field->getPresentation());
            }
        }
    }
}
