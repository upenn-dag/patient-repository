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

use Accard\Bundle\CoreBundle\DataFixtures\FixtureManagerInterface;
use Accard\Component\Core\Exception\RedundantPersistanceException;
use Accard\Component\Option\Model\Option;

/**
 * Option Builder fixture.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionBuilder
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


    public function __construct(FixtureManagerInterface $fixtureManager,
                                FieldBuilder $fieldBuilder = null)
    {
        $this->fixtureManager = $fixtureManager;
        $this->context = $fieldBuilder;
        $this->option = new Option;
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
     * Has option value.
     * 
     * @param OptionValue $optionValue
     * @return boolean
     */
    public function hasOptionValue($optionValue)
    {
        return isset($this->values[$optionValue]);
    }

    /**
     * Get option value.
     * 
     * @param OptionValue $optionValue
     * @return OptionBuilder
     */
    public function getOptionValue($optionValue)
    {
        if ($this->hasOptionValue($optionValue)) {
            return $this->optionValues[$optionValue];
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