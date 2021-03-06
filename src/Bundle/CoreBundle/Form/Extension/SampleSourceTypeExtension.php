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
 * Sample source form type extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SampleSourceTypeExtension extends AbstractTypeExtension
{
    /**
     * Patient class FQCN.
     *
     * @var string
     */
    protected $patientClass;


    /**
     * Constructor.
     *
     * @param string $patientClass
     */
    public function __construct($patientClass)
    {
        $this->patientClass = $patientClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['use_patient']) {
            $builder->add('patient', 'accard_patient_choice');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'use_patient' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'accard_sample_source';
    }
}
