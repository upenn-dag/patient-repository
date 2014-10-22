<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PatientBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Component\Patient\Builder\PatientBuilderInterface;
use Accard\Bundle\PatientBundle\Form\EventListener\DefaultPatientFieldListener;
use Accard\Bundle\OptionBundle\Form\Type\OptionValueChoiceType;
use Accard\Component\Option\Provider\OptionProviderInterface;

/**
 * Patient form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientType extends AbstractType
{
    /**
     * Data class.
     *
     * @var string
     */
    protected $dataClass;

    /**
     * Validation groups.
     *
     * @var array
     */
    protected $validationGroups;

    /**
     * Field builder.
     *
     * @var PatientBuilderInterface
     */
    protected $patientBuilder;

    /**
     * Option provider..
     *
     * @var OptionProviderInterface
     */
    protected $optionProvider;


    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param array $validationGroups
     * @param PatientBuilderInterface $builder
     * @param OptionProviderInterface $optionProvider
     */
    public function __construct($dataClass,
                                array $validationGroups,
                                PatientBuilderInterface $patientBuilder,
                                OptionProviderInterface $optionProvider)
    {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
        $this->patientBuilder = $patientBuilder;
        $this->optionProvider = $optionProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $genderOption = $this->optionProvider->getOptionByName('gender');
        $raceOption = $this->optionProvider->getOptionByName('race');

        $builder
            ->add('mrn', 'text', array(
                'label' => 'accard.patient.form.mrn',
                'required' => false,
            ))
            ->add('firstName', 'text', array(
                'label' => 'accard.patient.form.first_name'
                'required' => true,
            ))
            ->add('lastName', 'text', array(
                'label' => 'accard.patient.form.last_name'
                'required' => true,
            ))
            ->add('dateOfBirth', 'birthday', array(
                'label' => 'accard.patient.form.date_of_birth'
                'required' => true,
            ))
            ->add('dateOfDeath', 'date', array(
                'label' => 'accard.patient.form.date_of_death',
                'required' => false,
            ))
            ->add('gender', new OptionValueChoiceType($genderOption), array(
                'label' => 'accard.patient.form.gender',
                'required' => false,
            ))
            ->add('race', new OptionValueChoiceType($raceOption), array(
                'label' => 'accard.patient.form.race',
                'required' => false,
            ))
            ->add('fields', 'collection', array(
                'required'     => false,
                'type'         => 'accard_patient_field_value',
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->addEventSubscriber(
                new DefaultPatientFieldListener($builder->getFormFactory(), $this->patientBuilder)
            )
        ;

        if ($options['use_phases']) {
            $builder->add('phases', 'collection', array(
                'required'     => false,
                'type'         => 'accard_patient_phase_instance',
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'options'      => array('use_target' => false)
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => $this->dataClass,
                'validation_groups' => $this->validationGroups,
                'use_phases' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_patient';
    }
}
