<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FieldBundle\Form\Type;

use Accard\Bundle\FieldBundle\Form\EventListener\BuildFieldFormChoicesListener;
use Accard\Component\Field\Model\FieldTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Accard field type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldType extends AbstractType
{
    /**
     * Subject name.
     *
     * @var string
     */
    protected $subjectName;

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
     * @param string $subjectName
     * @param string $dataClass
     * @param array  $validationGroups
     */
    public function __construct($subjectName, $dataClass, array $validationGroups)
    {
        $this->subjectName = $subjectName;
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'accard.field.form.name'
            ))
            ->add('presentation', 'text', array(
                'label' => 'accard.field.form.presentation'
            ))
            ->add('type', 'choice', array(
                'label' => 'accard.field.form.type',
                'choices' => FieldTypes::getChoices()
            ))
            ->add('option', 'accard_option_choice', array(
                'label' => 'accard.field.form.option',
                'required' => false
            ))
            ->add('allowMultiple', 'checkbox', array(
                'label' => 'accard.field.form.allow_multiple',
                'required' => false,
            ))
            ->add('addable', 'checkbox', array(
                'label' => 'accard.field.form.addable',
                'required' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'        => $this->dataClass,
                'validation_groups' => $this->validationGroups
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return sprintf('accard_%s_field', $this->subjectName);
    }
}
