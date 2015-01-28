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

use DateTime;
use Accard\Component\Widget\AbstractType;
use Accard\Component\Widget\WidgetBuilderInterface;
use Accard\Component\Widget\WidgetView;
use Accard\Component\Widget\WidgetInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ReflectionObject;

/**
 * Date widget type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(WidgetView $view, WidgetInterface $widget, array $options)
    {
        $view->vars['now'] = new DateTime;
        $view->vars['date_format'] = $options['date_format'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data' => new DateTime(),
            'date_format' => 'm/d/Y',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'scalar';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'date';
    }
}