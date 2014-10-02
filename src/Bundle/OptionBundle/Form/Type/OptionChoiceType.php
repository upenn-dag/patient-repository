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
 * Option choice type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionChoiceType extends AbstractType
{
    /**
     * Attribute class name.
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
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'empty_value' => 'accard.form.field.choose_option',
                'class' => $this->className,
                'property' => 'presentation',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_option_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }
}
