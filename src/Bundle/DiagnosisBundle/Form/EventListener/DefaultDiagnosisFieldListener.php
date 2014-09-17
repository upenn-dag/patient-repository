<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Accard\Component\Diagnosis\Builder\DiagnosisBuilderInterface;

/**
 *
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DefaultDiagnosisFieldListener implements EventSubscriberInterface
{
    /**
     * Form factory.
     *
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * Diagnosis builder.
     *
     * @var DiagnosisBuilderInterface
     */
    private $builder;


    /**
     * Constructor.
     *
     * @param FormFactoryInterface $factory
     * @param DiagnosisBuilderInterface $builder
     */
    public function __construct(FormFactoryInterface $factory, DiagnosisBuilderInterface $builder)
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
     * Create all diagnosis fields not already set.
     *
     * @param FormEvent $event
     */
    public function buildForm(FormEvent $event)
    {
        if (null === ($diagnosis = $event->getData())) {
            return;
        }

        $this->builder->set($diagnosis);
        $possibleFields = $this->builder->getFieldRepository()->findAll();

        foreach ($possibleFields as $field) {
            if (!$diagnosis->hasFieldByName($field->getName())) {
                $this->builder->addField($field->getName(), null, $field->getPresentation());
            }
        }
    }
}
