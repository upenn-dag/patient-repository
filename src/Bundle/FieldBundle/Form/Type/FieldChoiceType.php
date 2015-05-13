<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FieldBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Field choice form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class FieldChoiceType extends AbstractType
{
    /**
     * Name of the fields subject.
     *
     * @var string
     */
    protected $subjectName;

    /**
     * Field class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param string $subjectName
     * @param string $className
     */
    public function __construct($subjectName, $className)
    {
        $this->subjectName = $subjectName;
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'class' => $this->className,
                'property' => 'presentation',
                'required' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return sprintf('accard_%s_field_choice', $this->subjectName);
    }
}
