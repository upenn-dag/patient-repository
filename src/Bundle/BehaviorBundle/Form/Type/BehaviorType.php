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
    protected $behaviorBuilder;


    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param array $validationGroups
     * @param OptionProviderInterface $optionProvider
     */
    public function __construct($dataClass,
                                array $validationGroups,
                                BehaviorBuilderInterface $behaviorBuilder)
    {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
        $this->behaviorBuilder = $behaviorBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prototype', 'accard_behavior_prototype_choice', array(
                'label' => 'accard.behavior.form.prototype',
            ))
            ->add('startDate', 'date', array(
                'label' => 'accard.behavior.form.start_date',
            ))
            ->add('endDate', 'date', array(
                'label' => 'accard.behavior.form.end_date',
                'required' => false,
            ))
            ->add('fields', 'collection', array(
                'label' => 'accard.behavior.form.fields',
                'required'     => false,
                'type'         => 'accard_behavior_prototype_field_value',
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->addEventSubscriber(
                new DefaultBehaviorFieldListener($builder->getFormFactory(), $this->behaviorBuilder)
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
