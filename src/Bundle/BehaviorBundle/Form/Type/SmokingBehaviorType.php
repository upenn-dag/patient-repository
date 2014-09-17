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

/**
 * Behavior Smoke (symantically 'Smoking') form type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 *
 * @todo add primary fields
 */
class SmokingBehaviorType extends BehaviorType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('frequency', 'text', array(
                'label'         => 'accard.behavior.smoking.form.frequency'
            ))
            ->add('type' , 'choice', array(
                'label'         => 'accard.behavior.smoking.form.type',
                'choices'       =>  array(
                    'Cigarettes'    => 'Cigarettes',
                    'Cigars'        => 'Cigars',
                    'Pipe'          => 'Pipe',
                    'Other'         => 'Other'
                )
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
        return 'accard_smoking_behavior';
    }
}
