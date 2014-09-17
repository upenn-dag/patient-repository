<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\BehaviorBundle\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Accard\Bundle\OptionBundle\Form\Type\OptionValueChoiceType;

/**
 * Behavior Education form type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 * @todo make the form dynamic based on the 'type' selection
 */
class EducationBehaviorType extends BehaviorType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $levelOption = $this->optionProvider->getOption('level');

        $builder
            ->add('level', new OptionValueChoiceType($levelOption), array(
                'label' => 'accard.behavior.education.form.level'
            ))
            ->add('years', 'text', array(
                'label' => 'accard.behavior.education.form.years'
            ))
            ->add('completed', 'choice', array(
                'expanded'      => true,
                'multiple'      => false,
                'choices'           => array(
                    'Yes'       =>      'Yes',
                    'No'        =>      'No',
                ),
                'label' => 'accard.behavior.education.form.completed'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'accard_behavior';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_education_behavior';
    }
}
