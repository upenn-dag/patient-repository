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
use Accard\Bundle\DiagnosisBundle\Form\Type\DiagnosisType;

/**
 * Patient diagnosis form type.
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class PatientDiagnosesType extends AbstractType
{
    /**
     * Data class.
     *
     * @var string
     */
    protected $dataClass;

    /**
     * Diagnosis FormType
     *
     * @var Diagnosis FormType
     */
    protected $diagnosisFormType;

    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param array $validationGroups
     * @param OptionProviderInterface $optionProvider
     */
    public function __construct( $dataClass, $diagnosisFormType )
    {
        $this->dataClass = $dataClass;
        $this->diagnosisFormType = $diagnosisFormType;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('diagnoses', 'collection', array(
                'type'      => $this->diagnosisFormType,
                'allow_add' => true,
                'allow_delete' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_patient_diagnoses';
    }
}