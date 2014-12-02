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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Component\Regimen\Builder\RegimenBuilderInterface;
use Accard\Bundle\RegimenBundle\Form\EventListener\DefaultRegimenFieldListener;

/**
 * Regimen activities form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenActivitiesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('regimenPrototype', 'accard_regimen_prototype_choice')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'Accard\Bundle\RegimenBundle\Model\RegimenActivities',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_regimen_activities';
    }
}
