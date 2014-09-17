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
 * Behavior Illict Drug form type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 * @todo Add primay fields
 */
class IllicitDrugBehaviorType extends BehaviorType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'text', array(
                'label'         => 'accard.behavior.illicit_drug.form.type'
            ))
            ->add('frequency', 'text', array(
                'label'         => 'accard.behavior.illicit_drug.form.frequency'
            ))
            ->add('method', 'text', array(
                'label'        => 'accard.behavior.illicit_drug.form.method'
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
        return 'accard_illicit_drug_behavior';
    }
}
