<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Flow create diagnosis phases form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CreateDiagnosisPhasesFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('patient', 'entity', array(
                'class' => $options['patient_class'],
                'property' => 'fullName',
            ))
            ->add('diagnosis', 'entity', array(
                'class' => $options['diagnosis_class'],
                'property' => 'id',
                'disabled' => true,
            ))
            ->add('phases', 'collection', array(
                'type' => 'accard_diagnosis_phase_instance',
                'allow_add' => true,
                'allow_delete' => true,
                'options' => array(
                    'use_target' => false,
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'Accard\Bundle\CoreBundle\Flow\Data\CreateDiagnosisPhasesData',
                'patient_class' => null,
                'diagnosis_class' => null,
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_flow_create_diagnosis_phases';
    }
}
