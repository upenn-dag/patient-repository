<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Allows us to easily override default messages for Symfony form types.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class InvalidMessageExtension extends AbstractTypeExtension
{
    /**
     * Form type of which to extend.
     *
     * @var string
     */
    private $baseType;

    /**
     * New invalid_message option.
     * 
     * @var string
     */
    private $newMessage;


    /**
     * Constructor.
     *
     * @param string $baseType
     */
    public function __construct($baseType, $newMessage)
    {
        $this->baseType = $baseType;
        $this->newMessage = $newMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => $this->newMessage
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return $this->baseType;
    }
}
