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
 * Patient phase choice type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientPhaseChoiceType extends AbstractType
{
    /**
     * Phase data class.
     * 
     * @var string
     */
    private $phaseClass;


    /**
     * Constructor.
     * 
     * @param string $phaseClass
     */
    public function __construct($phaseClass)
    {
        $this->phaseClass = $phaseClass;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'class' => $this->phaseClass,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'accard_phase_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_patient_phase_choice';
    }
}
