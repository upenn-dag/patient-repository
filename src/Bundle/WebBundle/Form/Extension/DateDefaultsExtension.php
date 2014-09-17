<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Sets default values for form fields.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DateDefaultsExtension extends AbstractTypeExtension
{
    /**
     * Form type of which to extend.
     * 
     * @var string
     */
    private $baseType;


    /**
     * Constructor.
     * 
     * @param string $baseType
     */
    public function __construct($baseType)
    {
        $this->baseType = $baseType;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('widget' => 'single_text'));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return $this->baseType;
    }
}
