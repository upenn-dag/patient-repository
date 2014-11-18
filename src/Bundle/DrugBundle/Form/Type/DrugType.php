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
 * Drug form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DrugType extends AbstractType
{
    /**
     * Data class.
     *
     * @var string
     */
    protected $dataClass;

    /**
     * Group class.
     *
     * @var string
     */
    protected $dataGroupClass;

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
     * @param string $dataGroupClass
     * @param array $validationGroups
     */
    public function __construct($dataClass, $dataGroupClass, array $validationGroups)
    {
        $this->dataClass = $dataClass;
        $this->dataGroupClass = $dataGroupClass;
        $this->validationGroups = $validationGroups;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'accard.drug.form.name',
                'required' => true,
            ))
            ->add('presentation', 'text', array(
                'label' => 'accard.drug.form.presentation',
                'required' => true,
            ))
            ->add('generic', 'accard_drug_choice', array(
                'label' => 'accard.drug.form.generic',
                'required' => false,
                'generic_only' => true,
            ))
        ;

        if ($options['create_groups']) {
            $builder->add('groups', 'collection', array(
                'type' => 'accard_drug_group',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
            ));
        } elseif ($options['select_groups']) {
            $builder->add('groups', 'entity', array(
                'class' => $this->dataGroupClass,
                'property' => 'presentation',
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
                'create_groups' => false,
                'select_groups' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_drug';
    }
}
