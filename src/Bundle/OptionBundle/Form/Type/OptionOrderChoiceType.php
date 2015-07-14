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
use Accard\Component\Option\Model\OptionOrder;

/**
 * Option order choices type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionOrderChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
            	'choices' => OptionOrder::getChoices(),
            	'preferred_choices' => array(OptionOrder::DEFAULT_ORDER),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
    	return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_option_order_choice';
    }
}
