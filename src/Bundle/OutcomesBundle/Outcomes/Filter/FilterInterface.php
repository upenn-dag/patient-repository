<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Outcomes\Filter;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\CoreBundle\State\ObjectFieldStateInterface;

/**
 * Outcomes filter interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FilterInterface
{
    /**
     * Filter a given field.
     *
     * @param ObjectFieldStateInterface $field
     * @param array $options
     */
    public function filter(ObjectFieldStateInterface $field, array $options);

    /**
     * Test if filter may respond to a given field.
     *
     * @return array
     */
    public function respondsTo();

    /**
     * Configure options resolver.
     *
     * @param OptionsResolverInterface $resolver
     * @param array $options
     * @return array
     */
    public function configureOptions(OptionsResolverInterface $resolver);

    /**
     * Resolve set of options into an array.
     *
     * @param OptionsResolverInterface $resolver
     * @param array $options
     * @return array
     */
    public function resolveOptions(OptionsResolverInterface $resolver, array $options);

    /**
     * Get filter name.
     *
     * @return string
     */
    public function getName();
}
