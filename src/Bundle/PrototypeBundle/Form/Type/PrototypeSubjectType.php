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
 * Accard prototype type.
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
     * Prototype class.
     * 
     * @var string
     */
    protected $prototypeClass;

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
     * @param string $prototypeClass
     * @param array  $validationGroups
     */
    public function __construct($subjectName, $dataClass, $prototypeClass, array $validationGroups)
    {
    	$this->subjectName = $subjectName;
        $this->dataClass = $dataClass;
        $this->prototypeClass = $prototypeClass;
        $this->validationGroups = $validationGroups;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('prototype', 'entity', array(
        		'class' => $options['prototype_class'],
        		'property' => 'presentation',
        	))
            ->add('activityDate', 'date', array(
                'label' => 'accard.form.prototype.activity_date'
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
                'prototype_class'   => $this->prototypeClass,
                'validation_groups' => $this->validationGroups,
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
