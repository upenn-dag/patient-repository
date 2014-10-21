<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FieldBundle\Form\EventListener;

use Accard\Component\Field\Model\FieldTypes;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Form event listener that builds choices for field form.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BuildFieldFormChoicesListener implements EventSubscriberInterface
{
    /**
     * Form factory.
     *
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $factory
     */
    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'buildChoices');
    }

    /**
     * Builds choices for field form.
     *
     * @param FormEvent $event
     */
    public function buildChoices(FormEvent $event)
    {
        if (null === ($field = $event->getData())) {
            return;
        }

        $type = $field->getType();

        if (FieldTypes::CHOICE === $type) {
            $event->getForm()->add('option', 'accard_option_choice', array(
                'required' => false,
            ));
        }
    }
}
