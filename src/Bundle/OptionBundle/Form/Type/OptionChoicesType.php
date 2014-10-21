<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OptionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Option choices type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionChoicesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_option_choices';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'accard_option_choice';
    }
}
