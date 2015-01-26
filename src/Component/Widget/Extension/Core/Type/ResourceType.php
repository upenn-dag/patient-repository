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
 * Resource widget type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class ResourceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildWidget(WidgetBuilderInterface $builder, array $options)
    {
        $data = $options['data'];
        $reflect = new ReflectionObject($data);
        $fields = [];

        foreach($reflect->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($data);
            $opts = array('data' => $value, 'show_title' => true, 'title' => $property->name);

            if (is_numeric($value)) {
                $fields[$property->name] = 'number';
                $builder->add($property->name, 'number', $opts);
            } elseif (is_string($value)) {
                $fields[$property->name] = 'string';
                $builder->add($property->name, 'string', $opts);
            } elseif (is_scalar($value)) {
                $fields[$property->name] = 'scalar';
                $builder->add($property->name, 'scalar', $opts);
            } elseif ($value instanceof \DateTime) {
                $fields[$property->name] = 'datetime';
                $builder->add($property->name, 'date', $opts);
            }
        }

        $builder->setAttribute('fields', $fields);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(WidgetView $view, WidgetInterface $widget, array $options)
    {
        //A widget's config is the resource (aka the Patient here)
        $config = $widget->getConfig();

        $view->vars['fields'] = $config->getAttribute('fields');
        $view->vars['grid'] = $config->getAttribute('grid');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'resource';
    }
}