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
 * Behavior Occupation form type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 * @todo Add primary fields
 */
class OccupationBehaviorType extends BehaviorType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $industryOption = $this->optionProvider->getOptionByName('industry');

        $builder
            ->add('industry', new OptionValueChoiceType($industryOption), array(
                'label' => 'accard.behavior.occupation.form.industry'
            ))

            ->add('hours', 'text', array(
                'label' => 'accard.behavior.occupation.form.hours'
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
        return 'accard_occupation_behavior';
    }
}
