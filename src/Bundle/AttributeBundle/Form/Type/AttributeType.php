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
use DAG\Bundle\OptionBundle\Form\Type\OptionValueChoiceType;
use DAG\Component\Option\Provider\OptionProviderInterface;
use Accard\Component\Attribute\Builder\AttributeBuilderInterface;
use Accard\Bundle\AttributeBundle\Form\EventListener\DefaultAttributeFieldListener;

/**
 * Attribute form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
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
    protected $attributeBuilder;



    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param array $validationGroups
     * @param AttributeBuilderInterface $builder
     */
    public function __construct(
        $dataClass,
        array $validationGroups,
        AttributeBuilderInterface $attributeBuilder
    ) {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
        $this->attributeBuilder = $attributeBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prototype', 'accard_attribute_prototype_choice', array(
                'label' => 'accard.attribute.form.prototype',
            ))
            ->add('fields', 'collection', array(
                'label' => 'accard.attribute.form.fields',
                'required'     => false,
                'type'         => 'accard_attribute_prototype_field_value',
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->addEventSubscriber(
                new DefaultAttributeFieldListener($builder->getFormFactory(), $this->attributeBuilder)
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
