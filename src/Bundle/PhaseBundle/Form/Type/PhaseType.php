<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PhaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Abstract phase type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PhaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', 'text', array(
                'label' => 'accard.phase.form.label',
            ))
            ->add('presentation', 'text', array(
                'label' => 'accard.phase.form.presentation',
            ))
            ->add('order', 'integer', array(
                'label' => 'accard.phase.form.order',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_phase';
    }
}
