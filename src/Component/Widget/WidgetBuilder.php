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
use ArrayIterator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\ImmutableEventDispatcher;
use Accard\Component\Widget\Exception\BadMethodCallException;
use Accard\Component\Widget\Exception\InvalidArgumentException;
use Accard\Component\Widget\Exception\UnexpectedTypeException;

/**
 * Widget builder.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetBuilder extends WidgetConfigBuilder implements IteratorAggregate, WidgetBuilderInterface
{
    /**
     * Widget children.
     *
     * @var WidgetBuilderInterface[]
     */
    private $children = array();

    /**
     * Unresolved widget children.
     *
     * @var array
     */
    private $unresolvedChildren = array();


    /**
     * Constructor.
     *
     * @param string $name
     * @param EventDispatcherInterface $dispatcher
     * @param array $options
     */
    public function __construct($name, EventDispatcherInterface $dispatcher, WidgetFactoryInterface $factory, array $options = array())
    {
        parent::__construct($name, $dispatcher, $options);

        $this->setWidgetFactory($factory);
    }

    /**
     * {@inheritdoc}
     */
    public function add($child, $type = null, array $options = array())
    {
        $this->assertNotLocked();

        if ($child instanceof self) {
            $this->children[$child->getName()] = $child;
            unset($this->unresolvedChildren[$child->getName()]);

            return $this;
        }

        if (!is_string($child)) {
            throw new UnexpectedTypeException($child, 'string or Accard\Component\Widget\WidgetBuilder');
        }

        if (null !== $type && !is_string($type) && !$type instanceof WidgetTypeInterface) {
            throw new UnexpectedTypeException($type, 'string or Accard\Component\Widget\WidgetTypeInterface');
        }

        $this->children[$child] = null;
        $this->unresolvedChildren[$child] = array(
            'type' => $type,
            'options' => $options,
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function create($name, $type = null, array $options = array())
    {
        $this->assertNotLocked();

        return $this->getWidgetFactory()->createNamedBuilder($name, $type, null, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        $this->assertNotLocked();

        if (isset($this->unresolvedChildren[$name])) {
            return $this->resolveChild($name);
        }

        if (isset($this->children[$name])) {
            return $this->children[$name];
        }

        throw new InvalidArgumentException(sprintf('The child named "%s" does not exist.', $name));
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
        $this->assertNotLocked();
        unset($this->unresolvedChildren[$name], $this->children[$name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        $this->assertNotLocked();

        return isset($this->unresolvedChildren[$name]) || isset($this->children[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        $this->assertNotLocked();
        $this->resolveChildren();

        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $this->assertNotLocked();

        return count($this->children);
    }

    /**
     * {@inheritdoc}
     */
    public function getWidgetConfig()
    {
        $config = parent::getWidgetConfig();

        $config->children = array();
        $config->unresolvedChildren = array();

        return $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidget()
    {
        $this->assertNotLocked();
        $this->resolveChildren();
        $widget = new Widget($this->getWidgetConfig());

        foreach ($this->children as $child) {
            $widget->add($child->setAutoInitialize(false)->getWidget());
        }

        if ($this->getAutoInitialize()) {
            $widget->initialize();
        }

        return $widget;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->assertNotLocked();

        return new ArrayIterator($this->all());
    }

    /**
     * Convert unresolved child into builder.
     *
     * @param string $name
     * @return WidgetBuilder
     */
    private function resolveChild($name)
    {
        $info = $this->unresolvedChildren[$name];
        $child = $this->create($name, $info['type'], $info['options']);
        $this->children[$name] = $child;
        unset($this->unresolvedChildren[$name]);

        return $child;
    }

    /**
     * Convert all unresolved children into builders.
     */
    private function resolveChildren()
    {
        foreach ($this->unresolvedChildren as $name => $info) {
            $this->children[$name] = $this->create($name, $info['type'], $info['options']);
        }

        $this->unresolvedChildren = array();
    }
}
