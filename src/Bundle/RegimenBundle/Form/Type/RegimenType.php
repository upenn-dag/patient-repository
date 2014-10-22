<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\RegimenBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Component\Regimen\Builder\RegimenBuilderInterface;
use Accard\Bundle\RegimenBundle\Form\EventListener\DefaultRegimenFieldListener;

/**
 * Regimen form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenType extends AbstractType
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
     * Regimen builder.
     *
     * @var RegimenBuilderInterface
     */
    protected $regimenBuilder;


    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param array $validationGroups
     * @param RegimenBuilderInterface $regimenBuilder
     */
    public function __construct($dataClass,
                                array $validationGroups,
                                RegimenBuilderInterface $regimenBuilder)
    {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
        $this->regimenBuilder = $regimenBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prototype', 'accard_regimen_prototype_choice', array(
                'label' => 'accard.regimen.form.prototype',
                'required' => true,
            ))
            ->add('startDate', 'date', array(
                'label' => 'accard.regimen.form.start_date',
                'required' => true,
            ))
            ->add('endDate', 'date', array(
                'label' => 'accard.regimen.form.end_date',
                'required' => false,
            ))
            ->add('fields', 'collection', array(
                'label' => 'accard.regimen.form.fields',
                'required'     => false,
                'type'         => 'accard_regimen_prototype_field_value',
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->addEventSubscriber(
                new DefaultRegimenFieldListener($builder->getFormFactory(), $this->regimenBuilder)
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
        return 'accard_regimen';
    }
}
