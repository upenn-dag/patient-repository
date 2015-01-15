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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Accard\Component\Field\Model\FieldTypes;
use Accard\Bundle\OptionBundle\Form\Type\OptionValueChoiceType;

/**
 * Form event listener that builds field forms dynamically based on incoming data.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BuildFieldValueFormListener implements EventSubscriberInterface
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
        return array(FormEvents::PRE_SET_DATA => 'buildForm');
    }

    /**
     * Builds proper field form.
     *
     * @param FormEvent $event
     */
    public function buildForm(FormEvent $event)
    {
        if (null === ($fieldValue = $event->getData())) {
            return;
        }

        $form = $event->getForm();
        $options = array(
            'label' => $fieldValue->getPresentation(),
            'auto_initialize' => false,
            'attr' => array(
                'data-field-name' => $fieldValue->getName(),
                'data-field-addable' => false
            ));

        if (is_array($fieldValue->getConfiguration())) {
            $options = array_merge_recursive($options, $fieldValue->getConfiguration());
        }

        $name = 'value';
        if (FieldTypes::CHOICE === $fieldValue->getType()) {
            $option = $fieldValue->getField()->getOption();
            $type = new OptionValueChoiceType($option);
            if ($fieldValue->getAllowMultiple()) {
                $name = 'values';
                $options['multiple'] = true;
                $options['expanded'] = true;
            }
            $options['attr']['data-field-addable'] = $fieldValue->isAddable() ? '1' : '0';
        } else {
            $type = $fieldValue->getType();
        }

        $form
            ->remove('field')
            ->add($this->factory->createNamed($name, $type, null, $options))
        ;
    }
}
