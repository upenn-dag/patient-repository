<?php
namespace Accard\Bundle\PrototypeBundle\Twig;

/**
 * Prototype Bundle \ Twig \ Prototype Extension
 *
 * @author Dylan Pierce <dylan@booksmart.it>
 */
use Twig_Extension;
use Twig_SimpleFunction;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class PrototypeExtension extends Twig_Extension
{
	/**
	 * Get functions.
	 */
	public function getFunctions()
	{
		return array(
			new Twig_SimpleFunction('filterByPrototypeName', array($this, 'filterByPrototypeName')),
			new Twig_SimpleFunction('mapByFieldValue', array($this, 'mapByFieldValue')),
		);
	}

	/**
	 * Filter a collection of resources by a prototype name.
	 * 
	 * @param Collection $resources
	 * @param string $name
	 * @return Collection $resources
	 */
	public function filterByPrototypeName(Collection $resources, $name)
	{
		return $resources->filter(function($resource) use ($name)
		{
			return $resource->getPrototype()->getName() == $name;
		});
	}

	/**
	 * Remap a collection of resources by a prototype's field name value
	 * 
	 * @param Collection $resources
	 * @param string $fieldName
	 * @return Collection $resources
	 */
	public function mapByFieldValue(Collection $resources, $name)
	{
		$fieldValues = [];

		foreach($resources as $resource) {

			$fieldValue = $resource->getFieldByName($name)->getValue();

			$fieldValues[$fieldValue][$resource->getId()] = $resource;

		}

		return $fieldValues;

	}

	/**
	 * Get name.
	 */
	public function getName()
	{
		return 'prototype_extension';
	}
}
