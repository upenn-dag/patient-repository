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

use IteratorAggregate;
use Symfony\Component\Form\Util\OrderedHashMap;
use Accard\Component\Widget\Exception\LogicException;
use Accard\Component\Widget\Exception\RuntimeException;
use Accard\Component\Widget\Exception\OutOfBoundsException;

/**
 * Widget representation.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Widget implements IteratorAggregate, WidgetInterface
{
    private $config;
    private $parent;
    private $children;
    private $data;
    private $defaultDataSet = false;
    private $lockSetData = false;

    public function __construct(WidgetConfigInterface $config)
    {
        if ($config->getInheritData()) {
            $this->defaultDataSet = true;
        }

        $this->config = $config;
        $this->children = new OrderedHashMap();
    }

    public function __clone()
    {
        $this->children = clone $this->children;

        foreach ($this->children as $key => $child) {
            $this->children[$key] = clone $child;
        }
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getName()
    {
        return $this->config->getName();
    }

    public function setParent(WidgetInterface $parent = null)
    {
        if (null !== $parent && '' === $this->config->getName()) {
            throw new LogicException('A widget with an empty name may not have a parent form.');
        }

        $this->parent = $parent;

        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getRoot()
    {
        return $this->parent ? $this->parent->getRoot() : $this;
    }

    public function isRoot()
    {
        return null === $this->parent;
    }

    //public function setData($data);
    //public function getData();

    public function initialize()
    {
        if (null !== $this->parent) {
            throw new RuntimeException('Only root widgets should be initialized.');
        }

        if (!$this->defaultDataSet) {
            $this->setData($this->config->getData());
        }

        return $this;
    }

    public function all()
    {
        return iterator_to_array($this->children);
    }

    public function add($child, $type = null, array $options = array())
    {
        if (!$child instanceof WidgetInterface) {
            if (!is_string($child)) {
                throw new UnexpectedTypeException($child, 'string or Accard\Component\Widget\WidgetInterface');
            }

            if (null !== $type && !is_string($type) && !$type instanceof WidgetTypeInterface) {
                throw new UnexpectedTypeException($type, 'string or Accard\Component\Widget\WidgetTypeInterface');
            }

            $options['auto_initialize'] = false;
        } elseif ($child->getConfig()->getAutoInitialize()) {
            throw new RuntimeException(sprintf(
                'Auto initialization is only supported on root forms. You should set "auto_initialize" optionf to false on the widget "%s".',
                $child->getName()
            ));
        }

        $this->children[$child->getName()] = $child;
        $child->setParent($this);

        return $this;
    }

    public function remove($name)
    {
        if ($this->has($name)) {
            unset($this->children[$name]);
        }

        return $this;
    }

    public function has($name)
    {
        return isset($this->children[$name]);
    }

    public function get($name)
    {
        if ($this->has($name)) {
            return $this->children[$name];
        }

        throw new OutOfBoundsException(sprintf('Child "%s" does not exist.', $name));
    }

    public function getData()
    {
        if ($this->config->getInheritData()) {
            if (!$this->parent) {
                throw new RuntimeException('The widget is configured to inherit its parent\'s data, but has no parent.');
            }

            return $this->parent->getData();
        }

        if (!$this->defaultDataSet) {
            $this->setData($this->config->getData());
        }

        return $this->data;
    }

    public function setData($data)
    {
        if ($this->config->getInheritData()) {
            throw new RuntimeException('You cannot change to data of a widget inheriting its parent data.');
        }

        if ($this->lockSetData) {
            throw new RuntimeException('The set data has been locked by a PRE_SET_DATA listener.');
        }

        // TODO: Add events
        $this->lockSetData = true;
        $this->data = $data;
        $this->defaultDataSet = true;
        $this->lockSetData = false;

        return $this;
    }

    public function offsetExists($name)
    {
        return $this->has($name);
    }

    public function offsetGet($name)
    {
        return $this->get($name);
    }

    public function offsetSet($name, $child)
    {
        $this->add($child);
    }

    public function offsetUnset($name)
    {
        $this->remove($name);
    }

    public function getIterator()
    {
        return $this->children;
    }

    public function count()
    {
        return count($this->children);
    }

    public function createView(WidgetView $parent = null)
    {
        if (null === $parent && $this->parent) {
            $parent = $this->parent->createView();
        }

        $type = $this->config->getType();
        $options = $this->config->getOptions();
        $view = $type->createView($this, $parent);

        $type->buildView($view, $this, $options);

        foreach ($this->children as $name => $child) {
            $view->children[$name] = $child->createView($view);
        }

        $type->finishView($view, $this, $options);

        return $view;
    }
}
