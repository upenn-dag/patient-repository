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
 * Patient phase instance type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientPhaseInstanceType extends AbstractType
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
     * Constructor.
     *
     * @param string $dataClass
     * @param array $validationGroups
     */
    public function __construct($dataClass, array $validationGroups)
    {
        $this->dataClass = $dataClass;
        $this->phaseDataClass = $phaseDataClass;
        $this->targetDataClass = $targetDataClass;
        $this->validationGroups = $validationGroups;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('phase', 'entity', array(
        		'class' => $this->phaseDataClass,
        		'property' => 'presentation',
        		'label' => 'accard.patient_phase_instance.form.phase',
        	))
        	->add('target', 'entity', array(
        		'class' => $this->targetDataClass,
        		'property' => 'fullName',
        		'label' => 'accard.patient_phase_instance.form.target',
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
                'data_class' => $this->dataClass,
                'validation_groups' => $this->validationGroups
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'accard_phase_instance';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_patient_phase_instance';
    }
}
