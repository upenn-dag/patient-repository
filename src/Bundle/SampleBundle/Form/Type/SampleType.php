<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SampleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Component\Sample\Builder\SampleBuilderInterface;
use Accard\Bundle\SampleBundle\Form\EventListener\DefaultSampleFieldListener;

/**
 * Sample form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SampleType extends AbstractType
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
     * Sample builder.
     *
     * @var SampleBuilderInterface
     */
    protected $sampleBuilder;


    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param array $validationGroups
     * @param SampleBuilderInterface $sampleBuilder
     */
    public function __construct($dataClass,
                                array $validationGroups,
                                SampleBuilderInterface $sampleBuilder)
    {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
        $this->sampleBuilder = $sampleBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prototype', 'accard_sample_prototype_choice', array(
                'label' => 'accard.sample.form.prototype',
            ))
            ->add('amount', 'number', array(
                'label' => 'accard.sample.form.amount',
            ))
            ->add('fields', 'collection', array(
                'label' => 'accard.sample.form.fields',
                'required'     => false,
                'type'         => 'accard_sample_prototype_field_value',
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->addEventSubscriber(
                new DefaultSampleFieldListener($builder->getFormFactory(), $this->sampleBuilder)
            )
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
    public function getName()
    {
        return 'accard_sample';
    }
}
