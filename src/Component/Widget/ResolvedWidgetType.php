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

use Accard\Component\Widget\Exception\InvalidArgumentException;
use Accard\Component\Widget\Exception\UnexpectedTypeException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Wrapper for widget types.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResolvedWidgetType implements ResolvedWidgetTypeInterface
{
    private $innerType;
    private $parent;
    private $optionsResolver;


    /**
     * Constructor.
     *
     * @param WidgetTypeInterface $innerType
     * @param ResolvedWidgetTypeInterface|null $parent
     */
    public function __construct(WidgetTypeInterface $innerType, ResolvedWidgetTypeInterface $parent = null)
    {
        if (!preg_match('/^[a-z0-9_]*$/i', $innerType->getName())) {
            throw new InvalidArgumentException(sprintf(
                'The "%s" widget type name ("%s") is not valid. Names must only contain letters, numbers, and "_".',
                get_class($innerType),
                $innerType->getName()
            ));
        }

        $this->innerType = $innerType;
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->innerType->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getInnerType()
    {
        return $this->innerType;
    }

    /**
     * {@inheritdoc}
     */
    public function createBuilder(WidgetFactoryInterface $factory, $name, array $options = array())
    {
        $options = $this->getOptionsResolver()->resolve($options);
        $builder = $this->newBuilder($name, $factory, $options);
        $builder->setType($this);

        return $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function createView(WidgetInterface $widget, WidgetView $parent = null)
    {
        return $this->newView($parent);
    }

    /**
     * {@inheritdoc}
     */
    public function buildWidget(WidgetBuilderInterface $builder, array $options)
    {
        if (null !== $this->getParent()) {
            $this->parent->buildWidget($builder, $options);
        }

        $this->innerType->buildWidget($builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(WidgetView $view, WidgetInterface $widget, array $options)
    {
        if (null !== $this->parent) {
            $this->parent->buildView($view, $widget, $options);
        }

        $this->innerType->buildView($view, $widget, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(WidgetView $view, WidgetInterface $widget, array $options)
    {
        if (null !== $this->parent) {
            $this->parent->finishView($view, $widget, $options);
        }

        $this->innerType->finishView($view, $widget, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionsResolver()
    {
        if (null === $this->optionsResolver) {
            if (null !== $this->parent) {
                $this->optionsResolver = clone $this->parent->getOptionsResolver();
            } else {
                $this->optionsResolver = new OptionsResolver();
            }

            $this->innerType->setDefaultOptions($this->optionsResolver);
        }

        return $this->optionsResolver;
    }

    /**
     * Create a new builder instance.
     *
     * @param string $name
     * @param WidgetFactoryInterface $factory
     * @param array $options
     * @return WidgetBuilderInterface
     */
    protected function newBuilder($name, WidgetFactoryInterface $factory, array $options)
    {
        return new WidgetBuilder($name, new EventDispatcher(), $factory, $options);
    }

    /**
     * Create a new view instance.
     *
     * @param WidgetView|null $parent
     * @return WidgetView
     */
    protected function newView(WidgetView $parent = null)
    {
        return new WidgetView($parent);
    }
}
