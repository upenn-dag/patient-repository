<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Abstract phase instance type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PhaseInstanceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['explicit_dates']) {
            $builder
                ->add('startDate', 'date', array(
                    'label' => 'accard.phase_instance.form.start_date',
                ))
                ->add('endDate', 'date', array(
                    'label' => 'accard.phase_instance.form.end_date',
                ))
            ;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'explicit_dates' => true,
                'use_target' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_phase_instance';
    }
}
