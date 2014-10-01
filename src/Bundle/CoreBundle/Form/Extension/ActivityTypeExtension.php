<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Form\Extension;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Activity form type extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityTypeExtension extends AbstractTypeExtension
{
    /**
     * Patient class FQCN.
     *
     * @var string
     */
    protected $patientClass;

    /**
     * Diagnosis class FQCN.
     *
     * @var string
     */
    protected $diagnosisClass;


    /**
     * Constructor.
     *
     * @param string $patientClass
     * @param string $diagnosisClass
     */
    public function __construct($patientClass, $diagnosisClass)
    {
        $this->patientClass = $patientClass;
        $this->diagnosisClass = $diagnosisClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['use_patient']) {
            $builder
                ->add('patient', 'entity', array(
                    'label' => 'accard.patient.entity_name',
                    'class' => $this->patientClass,
                    'property' => 'fullName',
                ))
            ;
        }

        if ($options['use_diagnosis']) {
            $builder->add('diagnosis', 'entity', array(
                'label' => 'accard.diagnosis.entity_name',
                'class' => $this->diagnosisClass,
                'property' => 'id',
                'disabled' => true,
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
                'use_patient' => true,
                'use_diagnosis' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'accard_activity';
    }
}
