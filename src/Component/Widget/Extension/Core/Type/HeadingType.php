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

/**
 * Heading widget type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class HeadingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function finishView(WidgetView $view, WidgetInterface $widget, array $options)
    {
        $view->vars['translate'] = $options['translate'];
        $view->vars['heading'] = $options['heading'];
        $view->vars['level'] = $options['level'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'heading' => 'Heading',
            'translate' => false,
            'level' => 1,
        ));

        $resolver->setAllowedValues(array(
        	'level' => range(1, 6),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'heading';
    }
}
