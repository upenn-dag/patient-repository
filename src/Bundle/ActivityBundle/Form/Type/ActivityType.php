<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ActivityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Component\Activity\Builder\ActivityBuilderInterface;
use Accard\Bundle\ActivityBundle\Form\EventListener\DefaultActivityFieldListener;

/**
 * Activity form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityType extends AbstractType
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
     * Activity builder.
     *
     * @var ActivityBuilderInterface
     */
    protected $activityBuilder;


    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param array $validationGroups
     * @param ActivityBuilderInterface $activityBuilder
     */
    public function __construct(
        $dataClass,
        array $validationGroups,
        ActivityBuilderInterface $activityBuilder
    ) {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
        $this->activityBuilder = $activityBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prototype', 'accard_activity_prototype_choice', array(
                'label' => 'accard.activity.form.prototype',
            ))
            ->add('activityDate', 'date', array(
                'label' => 'accard.activity.form.activity_date',
            ))
            ->add('fields', 'collection', array(
                'label' => 'accard.activity.form.fields',
                'required'     => false,
                'type'         => 'accard_activity_prototype_field_value',
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->addEventSubscriber(
                new DefaultActivityFieldListener($builder->getFormFactory(), $this->activityBuilder)
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
        return 'accard_activity';
    }
}
