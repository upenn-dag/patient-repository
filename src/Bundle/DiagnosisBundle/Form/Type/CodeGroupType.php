<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Diagnosis code group form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeGroupType extends AbstractType
{
    /**
     * Data class.
     *
     * @var string
     */
    protected $dataClass;

    /**
     * Code class.
     *
     * @var string
     */
    protected $dataCodeClass;

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
     * @param string $dataCodeClass
     * @param array $validationGroups
     */
    public function __construct($dataClass, $dataCodeClass, array $validationGroups)
    {
        $this->dataClass = $dataClass;
        $this->dataCodeClass = $dataCodeClass;
        $this->validationGroups = $validationGroups;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'accard.diagnosis_code_group.form.name',
            ))
            ->add('presentation', 'text', array(
                'label' => 'accard.diagnosis_code_group.form.presentation',
            ))
        ;

        if ($options['create_codes']) {
            $builder->add('codes', 'collection', array(
                'type' => 'accard_diagnosis_code',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
            ));
        } elseif ($options['select_codes']) {
            $builder->add('codes', 'entity', array(
                'class' => $this->dataCodeClass,
                'property' => 'description',
                'expanded' => true,
                'multiple' => true,
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
                'create_codes' => false,
                'select_codes' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_diagnosis_code_group';
    }
}
