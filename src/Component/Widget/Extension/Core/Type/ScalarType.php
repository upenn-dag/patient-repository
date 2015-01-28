<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Widget\Extension\Core\Type;

use Accard\Component\Widget\AbstractType;
use Accard\Component\Widget\WidgetBuilderInterface;
use Accard\Component\Widget\WidgetView;
use Accard\Component\Widget\WidgetInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ReflectionObject;

/**
 * Scalar widget type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class ScalarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(WidgetView $view, WidgetInterface $widget, array $options)
    {
        $view->vars['show_title'] = $options['show_title'];
        $view->vars['title'] = $options['title'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data' => null,
            'show_title' => false,
            'title' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'scalar';
    }
}