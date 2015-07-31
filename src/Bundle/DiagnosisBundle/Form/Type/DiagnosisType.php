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

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use DAG\Bundle\OptionBundle\Form\Type\OptionValueChoiceType;
use DAG\Component\Option\Provider\OptionProviderInterface;
use Accard\Component\Diagnosis\Builder\DiagnosisBuilderInterface;
use Accard\Bundle\DiagnosisBundle\Form\EventListener\DefaultDiagnosisFieldListener;
use Accard\Bundle\DiagnosisBundle\Provider\CodeGroupProvider;

/**
 * Diagnosis form type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisType extends AbstractType
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
     * @var DiagnosisBuilderInterface
     */
    protected $builder;

    /**
     * Diagnosis code group provider.
     *
     * @var CodeGroupProvider
     */
    protected $codeGroupProvider;


    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param array $validationGroups
     * @param OptionProviderInterface $optionProvider
     */
    public function __construct(
        $dataClass,
        array $validationGroups,
        DiagnosisBuilderInterface $builder,
        CodeGroupProvider $codeGroupProvider
    ) {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
        $this->builder = $builder;
        $this->codeGroupProvider = $codeGroupProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $group = $this->codeGroupProvider->getGroupByName($options['code_group']);
        $choices = $group->getCodes();

        if (empty($choices)) {
            throw new \RuntimeException('The code group provided to diagnosis form MUST contain codes.');
        }

        $codeClass = get_class($choices->first());

        $builder
            ->add('code', 'entity', array(
                  'class' => $codeClass,
                  'property' => 'description',
                  'choices' => $choices,
                  'label' => 'accard.diagnosis.form.code',
            ))
            ->add('startDate', 'date', array(
                'label' => 'accard.diagnosis.form.start_date',
            ))
            ->add('fields', 'collection', array(
                'required'     => false,
                'type'         => 'accard_diagnosis_field_value',
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->addEventSubscriber(
                new DefaultDiagnosisFieldListener($builder->getFormFactory(), $this->builder)
            )
        ;

        if ($options['show_end_date']) {
            $builder->add('endDate', 'date', array(
                'label' => 'accard.diagnosis.form.end_date',
                'required' => false,
            ));
        }

        if ($options['use_phases']) {
            $builder->add('phases', 'collection', array(
                'required'     => false,
                'type'         => 'accard_diagnosis_phase_instance',
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'options'      => array('use_target' => false)
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
                'code_group' => 'main',
                'show_end_date' => true,
                'use_phases' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_diagnosis';
    }
}
