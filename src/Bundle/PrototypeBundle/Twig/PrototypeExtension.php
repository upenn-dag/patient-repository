<?php

namespace Accard\Bundle\PrototypeBundle\Twig;

use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Accard prototype Twig extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <dylan@booksmart.it>
 */
class PrototypeExtension extends Twig_Extension implements ContainerAwareInterface
{
    private $environment;
    private $container;

    /**
     * {@inheritdoc}
     */
    public function initRuntime(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get functions.
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('filterByPrototypeName', array($this, 'filterByPrototypeName')),
            new Twig_SimpleFunction('mapByFieldValue', array($this, 'mapByFieldValue')),
            new Twig_SimpleFunction('accard_prototypes', array($this, 'getObjectPrototypes'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Gets the prototypes available on a given object.
     *
     * @param string $objectName
     * @return PrototypeInterface[]
     */
    public function getObjectPrototypes($objectName)
    {
        $provider = sprintf("accard.provider.%s_prototype", $objectName);

        if (!$this->container->has($provider)) {
            throw new \RuntimeException(sprintf('You have requested a non-existent prototype provider for "%s".', $objectName));
        }

        $provider = $this->container->get($provider);

            return $provider->getPrototypes();
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
        return 'accard_prototype';
    }
}
