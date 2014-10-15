<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\DataFixtures\Builder;

use ArrayAccess;
use Iterator;
use Countable;
use BadMethodCallException;
use InvalidArgumentException;
use Accard\Bundle\CoreBundle\DataFixtures\FixtureManagerInterface;
use Accard\Component\Core\Exception\RedundantPersistanceException;
use Accard\Component\Option\Model\Option;
use Accard\Component\Option\Model\OptionInterface;
use Accard\Component\Option\Model\OptionValueInterface;

/**
 * Option Builder fixture.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionBuilder implements ArrayAccess, Iterator, Countable
{
    /**
     * Option
     *
     * @var Option
     */
    private $option;

    /**
     * Fixture manager
     *
     * @var FixtureManager
     */
    private $fixtureManager;

    /**
     * Context
     *
     * @var FieldBuilder
     */
    private $context;

    /**
     * Option Values
     *
     * @var array
     */
    private $optionValues = array();

    /**
     * Is persisted
     *
     * @var boolean
     */
    private $persisted = false;


    /**
     * Constructor.
     *
     * @param FixtureManagerInterface $fixtureManager
     * @param OptionInterface $option
     * @param FieldBuilder $fieldBuilder
     */
    public function __construct(FixtureManagerInterface $fixtureManager,
                                OptionInterface $option = null,
                                FieldBuilder $fieldBuilder = null)
    {
        $this->fixtureManager = $fixtureManager;
        $this->context = $fieldBuilder;
        $this->option = $option ?: new Option;

        foreach ($this->option->getValues() as $optionValue) {
            $this->createBareOptionValue($optionValue);
        }
    }

    /**
     * Set name.
     *
     * @param string $name
     * @return OptionBuilder
     */
    public function setName($name)
    {
        $this->assertNotPersisted();

        $this->option->setName($name);

        return $this;
    }

    /**
     * Set presentation.
     *
     * @param string $presentation
     * @return OptionBuilder
     */
    public function setPresentation($presentation)
    {
        $this->assertNotPersisted();

        $this->option->setPresentation($presentation);

        return $this;
    }

    /**
     * Get option
     *
     * @return Option
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Test for presence of option value by name.
     *
     * @param string $optionName
     * @return boolean
     */
    public function hasOptionValue($optionName)
    {
        return isset($this->optionValues[$optionName]);
    }

    /**
     * Get option value by name.
     *
     * @param string $optionName
     * @return OptionBuilder
     */
    public function getOptionValue($optionName)
    {
        if ($this->hasOptionValue($optionName)) {
            return $this->optionValues[$optionName];
        }
    }

    /**
     * Create Option Value
     *
     * @param OptionValue $value
     * @return OptionBuilder
     */
    public function createOptionValue($value)
    {
        $this->assertNotPersisted();

        $optionValueBuilder = new OptionValueBuilder($this->fixtureManager, $this);
        $this->optionValues[$value] = $optionValueBuilder;

        return $optionValueBuilder->setValue($value);
    }

    /**
     * Create a bare option value.
     *
     * @param OptionValueInterface $optionValue
     */
    private function createBareOptionValue($optionValue)
    {
        $this->assertNotPersisted();

        $builder = new OptionValueBuilder($this->fixtureManager, $this, $optionValue);
        $this->optionValues[$optionValue->getValue()] = $builder;
    }

    /**
     * Get option from storage or create it.
     *
     * @param string $subject
     * @param string $name
     * @param string|null $presentation
     * @return OptionBuilder
     */
    public function getOrCreateOptionValue($name, $presentation)
    {
        if ($this->fixtureManager->hasOptionValue($name)) {
            return $this->fixtureManager->getOptionValue($name);
        }

        return $this->createOption($name, $presentation);
    }

    /**
     * Add option value
     *
     * @param OptionValue $value
     * @return OptionBuilder
     */
    public function addOptionValue($value)
    {
        $this->assertNotPersisted();

        $value = $this->createOptionValue($value);

        return $this;
    }

    /**
     * Remove OptionValue
     *
     * @param OptionValue $value
     * @return OptionBuilder
     */
    public function removeOptionValue($value)
    {
        $this->assertNotPersisted();

        if ($this->hasValue($value)) {
            unset($this->optionValues[$value]);
        }

        return $this;
    }

    /**
     * End and associate Option Values
     *
     * @return FieldBuilder | OptionBuilder
     */
    public function end()
    {
        $this->assertNotPersisted();

        foreach($this->optionValues as $optionValue) {
            $this->option->addValue($optionValue->getOptionValue());
        }

        return $this->context ?: $this;
    }

    /**
     * Persist
     *
     * @return OptionBuilder
     */
    public function persist()
    {
        $this->end();

        $this->fixtureManager->objectManager->persist($this->option);
        $this->persisted = true;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->hasOptionValue($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if (!$this->hasOptionValue($offset)) {
            throw new InvalidArgumentException(sprintf(
                'Option value "%s" is not included in the %s option.',
                $offset,
                $this->option->getName()
            ));
        }

        return $this->optionValues[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        throw new BadMethodCallException('Setting option values directly is not supported.');
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        throw new BadMethodCallException('Un-setting option values directly is not supported.');
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->optionValues);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->optionValues);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return next($this->optionValues);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        return reset($this->optionValues);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return null !== key($this->optionValues);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->optionValues);
    }

    /**
     * Assert option isn't already persisted
     */
    private function assertNotPersisted()
    {
        if ($this->persisted) {
            $option = $this->getOption();
            throw new RedundantPersistanceException($option->getName(), get_class($option));
        }
    }
}