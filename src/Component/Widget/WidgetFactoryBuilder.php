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

/**
 * Widget factory builder.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetFactoryBuilder implements WidgetFactoryBuilderInterface
{
	/**
	 * Resolved widget type factory.
	 * 
	 * @var ResolvedWidgetTypeFactoryInterface
	 */
	private $resolvedTypeFactory;

	/**
	 * Extensions.
	 * 
	 * @var WidgetExtensionInterface[]
	 */
	private $extensions = array();

	/**
	 * Types.
	 * 
	 * @var WidgetTypeInterface[]
	 */
	private $types = array();


    /**
     * {@inheritdoc}
     */
    public function setResolvedTypeFactory(ResolvedWidgetTypeFactoryInterface $resolvedTypeFactory)
    {
    	$this->resolvedTypeFactory = $resolvedTypeFactory;

    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFactory()
    {
    	$extensions = $this->extensions;

    	if (count($this->types) > 0) {
    		$extensions[] = new PreloadedExtension($this->types);
    	}

    	$resolvedTypeFactory = $this->resolvedTypeFactory ?: new ResolvedWidgetTypeFactory();
    	$registry = new WidgetRegistry($extensions, $resolvedTypeFactory);

    	return new WidgetFactory($registry, $resolvedTypeFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function addExtension(WidgetExtensionInterface $extension)
    {
    	$this->extensions[] = $extension;

    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addExtensions(array $extensions)
    {
    	$this->extensions = array_merge($this->extensions, $extensions);

    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addType(WidgetTypeInterface $type)
    {
    	$this->types[$type->getName()] = $type;

    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTypes(array $types)
    {
    	foreach ($types as $type) {
    		$this->addType($type);
    	}

    	return $this;
    }
}
