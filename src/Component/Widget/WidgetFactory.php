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

use Accard\Component\Widget\Exception\UnexpectedTypeException;

/**
 * Widget factory.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetFactory implements WidgetFactoryInterface
{
    /**
     * Widget registry.
     *
     * @var WidgetRegistryInterface
     */
    private $registry;

    /**
     * Resolved type factory.
     *
     * @var ResolvedWidgetTypeFactoryInterface
     */
    private $resolvedTypeFactory;


    /**
     * Constructor.
     *
     * @param WidgetRegistryInterface $registry
     * @param ResolvedWidgetTypeFactoryInterface $factory
     */
    public function __construct(WidgetRegistryInterface $registry, ResolvedWidgetTypeFactoryInterface $resolvedTypeFactory)
    {
        $this->registry = $registry;
        $this->resolvedTypeFactory = $resolvedTypeFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function create($type = 'widget', $data = null, array $options = array())
    {
        return $this->createBuilder($type, $data, $options)->getWidget();
    }

    /**
     * {@inheritdoc}
     */
    public function createNamed($name, $type = 'widget', $data = null, array $options = array())
    {
        return $this->createNamedBuilder($name, $type, $data, $options)->getWidget();
    }

    /**
     * {@inheritdoc}
     */
    public function createBuilder($type = 'widget', $data = null, array $options = array())
    {
        $name = $type instanceof WidgetTypeInterface ? $type->getName() : $type;

        return $this->createNamedBuilder($name, $type, $data, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function createNamedBuilder($name, $type = 'widget', $data = null, array $options = array())
    {
        if (null !== $data && !isset($options['data'])) {
            $options['data'] = $data;
        }

        if ($type instanceof WidgetTypeInterface) {
            $type = $this->resolveType($type);
        } elseif (is_string($type)) {
            $type = $this->registry->getType($type);
        } elseif (!$type instanceof ResolvedWidgetTypeInterface) {
            throw new UnexpectedTypeException($type, 'string, Accard\Component\Widget\ResolvedWidgetTypeInterface or Accard\Component\Widget\WidgetTypeInterface');
        }

        $builder = $type->createBuilder($this, $name, $options);
        $type->buildWidget($builder, $builder->getOptions());

        return $builder;
    }

    /**
     * Converts a wiget type into a resolved widget type.
     *
     * @param WidgetTypeInterface $type
     * @return ResolvedWidgetTypeInterface
     */
    private function resolveType(WidgetTypeInterface $type)
    {
        $parentType = $type->getParent();

        if ($parentType instanceof WidgetTypeInterface) {
            $parentType = $this->resolveType($parentType);
        } elseif (null !== $parentType) {
            $parentType = $this->registry->getType($parentType);
        }

        return $this->resolvedTypeFactory->createResolvedType($type, array(), $parentType);
    }
}
