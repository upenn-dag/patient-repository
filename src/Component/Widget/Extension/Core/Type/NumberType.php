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
 * Number widget type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class NumberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data' => 0,
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
        return 'number';
    }
}