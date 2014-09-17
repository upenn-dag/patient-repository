<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\AttributeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\OptionBundle\Form\Type\OptionValueChoiceType;
use Accard\Component\Option\Provider\OptionProviderInterface;
use Accard\Component\Attribute\Builder\AttributeBuilderInterface;
use Accard\Bundle\AttributeBundle\Form\EventListener\DefaultAttributeFieldListener;

/**
 * Attribute form type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class AttributeType extends AbstractType
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
     * @var AttributeBuilderInterface
     */
    protected $builder;



    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param array $validationGroups
     * @param AttributeBuilderInterface $builder
     */
    public function __construct($dataClass,
                                array $validationGroups,
                                AttributeBuilderInterface $builder)
    {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
        $this->builder = $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventSubscriber(
                new DefaultAttributeFieldListener($builder->getFormFactory(), $this->builder)
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
        return 'accard_attribute';
    }
}
