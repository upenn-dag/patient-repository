<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Form\Type\Filter;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Patient filter form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mrn', 'text', array(
                'required' => false,
                'label'    => 'accard.patient.filter.mrn',
                'attr'     => array(
                    'placeholder' => 'accard.patient.filter.mrn',
                )
            ))
            ->add('firstName', 'text', array(
                'required' => false,
                'label'    => 'accard.patient.filter.first_name',
                'attr'     => array(
                    'placeholder' => 'accard.patient.filter.first_name',
                )
            ))
            ->add('lastName', 'text', array(
                'required' => false,
                'label'    => 'accard.patient.filter.last_name',
                'attr'     => array(
                    'placeholder' => 'accard.patient.filter.last_name',
                )
            ))
            ->add('deceased', 'checkbox', array(
                'required'    => false,
                'label' => 'accard.patient.filter.deceased',
            ))
        ;

        /* =
         * We need to convert the string '1' or '0' set on the filter form into a
         * boolean value before we set the data on the form or the checkbox will
         * throw an exception.
         */
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            if (isset($data['deceased']) && !empty($data['deceased'])) {
                $data['deceased'] = (boolean) $data['deceased'];
            }
            $event->setData($data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => null,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_patient_filter';
    }
}
