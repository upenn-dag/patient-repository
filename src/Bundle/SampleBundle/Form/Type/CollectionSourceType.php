<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SampleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Collection sample source form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CollectionSourceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'source_type' => 'collection',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
    	return 'accard_sample_source';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_sample_source_collection';
    }
}
