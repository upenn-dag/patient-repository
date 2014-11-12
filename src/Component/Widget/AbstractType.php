<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Widget;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Abstract widget type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class AbstractType implements WidgetTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildWidget(WidgetBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(WidgetView $view, WidgetInterface $form, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(WidgetView $view, WidgetInterface $form, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'widget';
    }
}
