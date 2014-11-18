<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ActivityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\PrototypeBundle\Form\Type\PrototypeType;

/**
 * Accard activity prototype type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityPrototypeType extends PrototypeType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);

        $builder
        	->add('allowDrug', 'checkbox', array(
        		'label' => 'accard.activity_prototype.form.allow_drug',
        		'required' => false,
        	))
        ;
    }
}
