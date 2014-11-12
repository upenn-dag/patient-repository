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

use Accard\Component\Widget\Exception\ExceptionInterface;
use Accard\Component\Widget\Exception\InvalidArgumentException;
use Accard\Component\Widget\Exception\UnexpectedTypeException;

/**
 * Widget registry.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetRegistry implements WidgetRegistryInterface
{
    /**
     * Widget types.
     *
     * @var WidgetTypeInterface[]
     */
    private $types = array();

    /**
     * Widget extensions.
     *
     * @var WidgetExtensionInterface[]
     */
    private $extensions = array();

    /**
     * Resolved widget type factory.
     *
     * @var ResolvedWidgetTypeFactoryInterface
     */
    private $resolvedTypeFactory;


    /**
     * Constructor.
     *
     * @throws UnexpectedTypeException If a non-valid extension is provided.
     * @param WidgetExtensionInterface[]
     * @param ResolvedFormTypeFactoryInterface $resolvedTypeFactory
     */
    public function __construct(array $extensions, ResolvedWidgetTypeFactoryInterface $resolvedTypeFactory)
    {
        foreach ($extensions as $widgetExtension) {
            if (!$widgetExtension instanceof WidgetExtensionInterface) {
                throw new UnexpectedTypeException($widgetExtension, 'Accard\Component\Widget\WidgetExtensionInterface');
            }
        }

        $this->extensions = $extensions;
        $this->resolvedTypeFactory = $resolvedTypeFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        if (!is_string($name)) {
            throw new UnexpectedTypeException($name, 'string');
        }

        if (!isset($this->types[$name])) {
            $type = null;

            foreach ($this->extensions as $extension) {
                if ($extension->hasType($name)) {
                    $type = $extension->getType($name);
                    break;
                }
            }

            if (!$type) {
                throw new InvalidArgumentException(sprintf('Could not load type "%s"', $name));
            }

            $this->resolveAndAddType($type);
        }

        return $this->types[$name];
    }

    /**
     * Wrap widget type.
     *
     * @param WidgetTypeInterface $type
     * @return ResolvedWidgetTypeInterface
     */
    private function resolveAndAddType(WidgetTypeInterface $type)
    {
        $parentType = $type->getParent();

        if ($parentType instanceof WidgetTypeInterface) {
            $this->resolveAndAddType($parentType);
            $parentType = $parentType->getName();
        }

        $this->types[$type->getName()] = $this->resolvedTypeFactory->createResolvedType(
            $type,
            $parentType ? $this->getType($parentType) : null
        );
    }

    /**
     * {@inheritdoc}
     */
    public function hasType($name)
    {
        if (isset($this->types[$name])) {
            return true;
        }

        try {
            $this->getType($name);
        } catch (ExceptionInterface $exception) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
}
