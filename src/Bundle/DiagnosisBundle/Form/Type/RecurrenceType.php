<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Diagnosis recurrence form type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @todo Add parent diagnosis field dynamically (accomodate patient???)
 */
class RecurrenceType extends DiagnosisType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Add logic to create recurrence primary field.
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'accard_diagnosis';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_diagnosis_recurrence';
    }
}
