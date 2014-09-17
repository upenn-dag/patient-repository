<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\AttributeBundle\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Accard\Bundle\OptionBundle\Form\Type\OptionValueChoiceType;

/**
 * Attribute Family Cancer History form type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class FamilyCancerHistoryAttributeType extends AttributeType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'accard_attribute';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_family_cancer_history_attribute';
    }
}
