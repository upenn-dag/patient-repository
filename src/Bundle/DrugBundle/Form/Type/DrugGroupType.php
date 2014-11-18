<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DrugBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Drug group form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DrugGroupType extends AbstractType
{
    /**
     * Data class.
     *
     * @var string
     */
    protected $dataClass;

    /**
     * Drug class.
     *
     * @var string
     */
    protected $dataDrugClass;

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
     * @param string $dataDrugClass
     * @param array $validationGroups
     */
    public function __construct($dataClass, $dataDrugClass, array $validationGroups)
    {
        $this->dataClass = $dataClass;
        $this->dataDrugClass = $dataDrugClass;
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

        if ($options['create_drugs']) {
            $builder->add('drugs', 'collection', array(
                'type' => 'accard_drug',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
            ));
        } elseif ($options['select_drugs']) {
            $builder->add('drugs', 'accard_drug_choice', array(
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
                'create_drugs' => false,
                'select_drugs' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_drug_group';
    }
}
