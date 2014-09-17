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

use Accard\Bundle\FieldBundle\Form\EventListener\BuildFieldValueFormListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Field value form type.
 * 
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValueType extends AbstractType
{
    /**
     * Fields subject name.
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
            ->add('field', sprintf('accard_%s_field_choice', $this->subjectName))
            ->addEventSubscriber(new BuildFieldValueFormListener($builder->getFormFactory()))
        ;

        $prototypes = array();
        foreach ($this->getFields($builder) as $field) {
            $prototypes[] = $builder->create('value', $field->getType(), $field->getConfiguration())->getForm();
        }

        $builder->setAttribute('prototypes', $prototypes);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['prototypes'] = array();

        foreach ($form->getConfig()->getAttribute('prototypes', array()) as $name => $prototype) {
            $view->vars['prototypes'][$name] = $prototype->createView($view);
        }
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
        return sprintf('accard_%s_field_value', $this->subjectName);
    }

    /**
     * Get fields
     *
     * @param FormBuilderInterface $builder
     *
     * @return FieldInterface[]
     */
    private function getFields(FormBuilderInterface $builder)
    {
        return $builder->get('field')->getOption('choice_list')->getChoices();
    }
}
