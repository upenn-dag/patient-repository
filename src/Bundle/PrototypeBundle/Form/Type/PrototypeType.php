<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PrototypeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Accard prototype type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PrototypeType extends AbstractType
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
                'label' => sprintf('accard.%s_prototype.form.name', $this->subjectName),
            ))
            ->add('presentation', 'text', array(
                'label' => sprintf('accard.%s_prototype.form.presentation', $this->subjectName),
            ))
            ->add('fields', 'collection', array(
                  'label' => sprintf('accard.%s_prototype.form.fields', $this->subjectName),
                  'type' => 'accard_activity_prototype_field_choice',
                  'allow_add' => true,
                  'allow_delete' => true,
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
        return sprintf('accard_%s_prototype', $this->subjectName);
    }
}
