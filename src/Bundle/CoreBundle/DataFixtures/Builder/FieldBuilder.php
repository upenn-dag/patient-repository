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
use Accard\Component\Field\Exception\InvalidFieldTypeException;
use Accard\Component\Core\Exception\RedundantPersistanceException;
use Accard\Component\Field\Model\FieldTypes;

/**
 * Field Builder fixture.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class FieldBuilder
{
    /**
     * Field
     *
     * @var Field
     */
    private $field;

    /**
     * Subject
     *
     * @var string
     */
    private $subject;

    /**
     * Fixture manager
     *
     * @var FixtureManager
     */
    private $fixtureManager;

    /**
     * Context
     *
     * @var PrototypeBuilder
     */
    private $context;

    /**
     * Option
     *
     * @var Option
     */
    private $option;

    /**
     * is persisted already
     *
     * @var boolean
     */
    private $persisted = false;


    public function __construct($subject,
                                FixtureManagerInterface $fixtureManager,
                                PrototypeBuilder $prototypeBuilder = null)
    {
        $this->subject = $subject;
        $this->fixtureManager = $fixtureManager;
        $this->context = $prototypeBuilder;
        $fieldClass = $this->getModelClass();
        $this->field = new $fieldClass();
    }

    /**
     * Get field.
     *
     * @return Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Get model class
     *
     * @return string
     */
    public function getModelClass()
    {
        return $this->fixtureManager->resolveClassFromParameter(
            sprintf('accard.model.%s_field.class', $this->subject)
        );
    }

    /**
     * Set name.
     *
     * @param string $name
     * @return FieldBuilder
     */
    public function setName($name)
    {
        $this->assertNotPersisted();
        $this->field->setName($name);

        return $this;
    }

    /**
     * Set presentation.
     *
     * @param string $presentation
     * @return FieldBuilder
     */
    public function setPresentation($presentation)
    {
        $this->assertNotPersisted();
        $this->field->setPresentation($presentation);

        return $this;
    }

    /**
     * Set type.
     *
     * @param string $type
     * @return FieldBuilder
     */
    public function setType($type)
    {
        $this->assertNotPersisted();

        if (!in_array($type, array_keys(FieldTypes::getChoices()))) {
            throw new InvalidFieldTypeException($type);
        }

        $this->field->setType($type);

        return $this;
    }

    /**
     * Allow multiple choice.
     *
     * @return FieldBuilder
     */
    public function enableMultipleChoice()
    {
        $this->assertNotPersisted();

        $this->field->setAllowMultiple(true);

        return $this;
    }

    /**
     * Disable multiple choice.
     *
     * @return FieldBuilder
     */
    public function disableMultipleChoice()
    {
        $this->assertNotPersisted();

        $this->field->setAllowMultiple(false);

        return $this;
    }

    /**
     * Has option.
     *
     * @param string $name
     * @return null | Option
     */
    public function hasOption($name)
    {
        return null === $this->option;
    }

    /**
     * Get option.
     *
     * @return Option
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Set option.
     *
     * @param OptionBuilder $optionBuilder
     * @return FieldBuilder
     */
    public function setOption(OptionBuilder $optionBuilder)
    {
        $this->assertNotPersisted();
        $this->option = $optionBuilder;

        return $this;
    }

    /**
     * Create option.
     *
     * @param string $name
     * @param string $presentation
     * @return OptionBuilder
     */
    public function createOption($name, $presentation)
    {
        $this->assertNotPersisted();

        $subjectAppended = $this->context ? $this->subject.'_prototype' : $this->subject;
        $optionBuilder = new OptionBuilder($this->fixtureManager, null, $this);
        $this->option = $optionBuilder;

        return $optionBuilder
            ->setName($name)
            ->setPresentation($presentation)
        ;
    }

    /**
     * Get option from storage or create it.
     *
     * @param string $subject
     * @param string $name
     * @param string|null $presentation
     * @return OptionBuilder
     */
    public function getOrCreateOption($name, $presentation)
    {
        if ($this->fixtureManager->hasOption($name)) {
            return $this->fixtureManager->getOption($name);
        }

        return $this->createOption($name, $presentation);
    }

    /**
     * End and persist.
     *
     * @return PrototypeBuilder | FieldBuilder
     */
    public function end()
    {
        if (!$this->persisted && $this->option) {
            $this->field->setOption($this->option->getOption());
        }

        return $this->context ?: $this;
    }

    /**
     * Persist.
     */
    public function persist()
    {
        $this->end();
        $this->persisted = true;
        $this->fixtureManager->objectManager->persist($this->field);
    }

    /**
     * Assert field's not already persisted
     *
     * @return boolean
     */
    private function assertNotPersisted()
    {
        if ($this->persisted) {
            $field = $this->getField();
            throw new RedundantPersistanceException($field->getName(), get_class($field));
        }
    }
}
