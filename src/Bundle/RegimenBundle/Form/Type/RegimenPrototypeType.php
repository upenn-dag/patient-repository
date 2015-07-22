<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\RegimenBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use DAG\Bundle\PrototypeBundle\Form\Type\PrototypeType;

/**
 * Accard regimen prototype type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenPrototypeType extends PrototypeType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('allowDrug', 'checkbox', array(
                'label' => 'accard.regimen_prototype.form.allow_drug',
                'required' => false,
            ))
            ->add('drugGroup', 'accard_drug_group_choice', array(
                'label' => 'accard.regimen_prototype.form.drug_group',
                'required' => false,
            ))
            ->add('activityPrototypes', 'collection', array(
                'type' => 'accard_activity_prototype_choice',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
        ;
    }
}
