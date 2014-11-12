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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Widget configuration.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetConfigBuilder implements WidgetConfigBuilderInterface
{
    /**
     * Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Type.
     *
     * @var ResolvedWidgetTypeInterface
     */
    protected $type;

    /**
     * Inherit parent form data.
     *
     * @var boolean
     */
    private $inheritData = false;

    /**
     * Data used when data is empty.
     *
     * @var mixed
     */
    private $emptyData;

    /**
     * Initial data.
     *
     * @var mixed
     */
    private $data;

    /**
     * Builder lock.
     *
     * @var boolean
     */
    private $locked = false;

    /**
     * Auto initialize builder.
     *
     * @var boolean
     */
    private $autoInitialize = false;

    /**
     * Builder options.
     *
     * @var array
     */
    protected $options;

    /**
     * Builder attributes.
     *
     * @var array
     */
    private $attributes = array();

    /**
     * Event dispatcher.
     *
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Widget factory.
     *
     * @var WidgetFactoryInterface
     */
    private $formFactory;


    /**
     * Constructor.
     *
     * @param string $name
     * @param EventDispatcherInterface $dispatcher
     * @param array $options
     */
    public function __construct($name, EventDispatcherInterface $dispatcher, array $options = array())
    {
        self::validateName($name);

        // Need data class?

        $this->name = (string) $name;
        $this->dispatcher = $dispatcher;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompound()
    {
        return $this->compound;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompound($compound)
    {
        $this->assertNotLocked();
        $this->compound = $compound;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(ResolvedWidgetTypeInterface $type)
    {
        $this->assertNotLocked();
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getInheritData()
    {
        return $this->inheritData;
    }

    /**
     * {@inheritdoc}
     */
    public function setInheritData($inheritData)
    {
        $this->assertNotLocked();
        $this->inheritData = $inheritData;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmptyData()
    {
        return $this->emptyData;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmptyData($emptyData)
    {
        $this->assertNotLocked();
        $this->emptyData = $emptyData;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        $this->assertNotLocked();
        $this->data = $data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAutoInitialize()
    {
        return $this->autoInitialize;
    }

    /**
     * {@inheritdoc}
     */
    public function setAutoInitialize($autoInitialize)
    {
        $this->autoInitialize = (boolean) $autoInitialize;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttribute($name, $value)
    {
        $this->assertNotLocked();
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributes(array $attributes)
    {
        $this->assertNotLocked();
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasAttribute($name)
    {
        return isset($this->attributes[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($name, $default = null)
    {
        return $this->hasAttribute($name) ? $this->attributes[$name] : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($name, $default = null)
    {
        return $this->hasOption($name) ? $this->options[$name] : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function addEventListener($eventName, $listener, $priority = 0)
    {
        $this->assertNotLocked();
        $this->dispatcher->addListener($eventName, $listener, $prority);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addEventSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->assertNotLocked();
        $this->dispatcher->addSubscriber($subscriber);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidgetFactory()
    {
        return $this->formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function setWidgetFactory(WidgetFactoryInterface $formFactory)
    {
        $this->assertNotLocked();
        $this->formFactory = $formFactory;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidgetConfig()
    {
        $this->assertNotLocked();
        $config = clone $this;
        $config->locked = true;

        return $config;
    }

    /**
     * Test if builder has been locked.
     *
     * @throws BadMethodCallException If builder has been locked.
     */
    protected function assertNotLocked()
    {
        if ($this->locked) {
            throw new BadMethodCallException('Widget builder methods are unavailable after conversion.');
        }
    }

    /**
     * Validates whether the given string is a valid form name.
     *
     * @throws UnexpectedTypeException  If the name is not a string or an integer.
     * @throws InvalidArgumentException If the name contains invalid characters.
     * @param string $name The tested form name.
     */
    public static function validateName($name)
    {
        if (null !== $name && !is_string($name) && !is_int($name)) {
            throw new UnexpectedTypeException($name, 'string, integer or null');
        }

        if (!self::isValidName($name)) {
            throw new InvalidArgumentException(sprintf(
                'The name "%s" contains illegal characters. Names should start with a letter, digit or underscore and only contain letters, digits, numbers, underscores ("_"), hyphens ("-") and colons (":").',
                $name
            ));
        }
    }

    /**
     * Test given string contains a valid form name.
     *
     * @param string $name
     * @return boolean
     */
    public static function isValidName($name)
    {
        return '' === $name || null === $name || preg_match('/^[a-zA-Z0-9_][a-zA-Z0-9_\-:]*$/D', $name);
    }
}
