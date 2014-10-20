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
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Sample source form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SourceType extends AbstractType
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
        $this->validationGroups = $validationGroups;
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['source_type'] = $options['source_type'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sourceDate', 'date', array(
                'label' => 'accard.sample_source.form.source_date',
            ))
            ->add('amount', 'number', array(
                'label' => 'accard.sample_source.form.amount',
                'required' => false,
            ))
        ;

        if ($options['use_samples']) {
            $builder->add('samples', 'collection', array(
                'label' => 'accard.sample_source.form.samples',
                'type' => 'accard_sample',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
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
                'is_derivative' => false,
                'use_samples' => true,
            ))
            ->setRequired(array('source_type'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_sample_source';
    }
}
