<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\BehaviorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\OptionBundle\Form\Type\OptionValueChoiceType;
use Accard\Component\Option\Provider\OptionProviderInterface;
use Accard\Component\Behavior\Builder\BehaviorBuilderInterface;
use Accard\Bundle\BehaviorBundle\Form\EventListener\DefaultBehaviorFieldListener;

/**
 * Behavior form type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BehaviorType extends AbstractType
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
     * @var BehaviorBuilderInterface
     */
    protected $builder;

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
     * @param OptionProviderInterface $optionProvider
     */
    public function __construct($dataClass,
                                array $validationGroups,
                                BehaviorBuilderInterface $builder,
                                OptionProviderInterface $optionProvider)
    {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
        $this->builder = $builder;
        $this->optionProvider = $optionProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', 'date', array(
                'label' => 'accard.behavior.form.start_date',
            ))
            ->add('endDate', 'date', array(
                'label' => 'accard.behavior.form.end_date',
                'required' => false,
            ))
            ->addEventSubscriber(
                new DefaultBehaviorFieldListener($builder->getFormFactory(), $this->builder)
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
        return 'accard_behavior';
    }
}
