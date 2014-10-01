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
use Accard\Component\Prototype\Model\PrototypeInterface;

/**
 * Prototype Builder.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class PrototypeBuilder
{
    /**
     * Fixture manager.
     * 
     * @var FixtureManagerInterface
     */
    private $fixtureManager;

    /**
     * Prototype subject.
     *
     * @var string
     */
    private $subject;

    /**
     * Prototype model.
     * 
     * @var PrototypeInterface
     */
    private $prototype;

    /**
     * Context.
     * 
     * @var this
     */
    private $context;

    /**
     * Fields array
     * 
     * @var array
     */
    private $fields = array();

    /**
     * Is already persisted
     * 
     * @var boolean
     */
    private $persisted = false;

    public function __construct($subject, FixtureManagerInterface $fixtureManager)
    {
        $this->subject = $subject;
        $this->fixtureManager = $fixtureManager;
        $prototypeClass = $this->getModelClass();
        $this->prototype = new $prototypeClass();
        $this->context = $this;
    }

    /**
     * Set prototype name.
     * 
     * @param string $name
     * @return PrototypeBuilder
     */
    public function setName($name)
    {
        $this->assertNotPersisted();

        $this->prototype->setName($name);

        return $this;
    }

    /**
     * Set prototype presentation.
     * 
     * @param string $presentation
     * @return PrototypeBuilder
     */
    public function setPresentation($presentation)
    {
        $this->assertNotPersisted();

        $this->prototype->setPresentation($presentation);

        return $this;
    }

    /**
     * Has field.
     * 
     * @param string $name
     */
    public function hasField($name)
    {
        return isset($this->fields[$name]);
    }

    /**
     * Get field.
     * 
     * @param string $name
     * @return Field
     */
    public function getField($name)
    {
        if ($this->hasField($name)) {
            return $this->fields[$name];
        }
    }

    /**
     * Create field.
     * 
     * @param string $name
     * @param string $presentation
     * @param string $type
     */
    public function createField($name, $presentation, $type)
    {
        $this->assertNotPersisted();

        $fieldBuilder = new FieldBuilder($this->subject.'_prototype', $this->fixtureManager, $this);
        $this->fields[$name] = $fieldBuilder;

        return $fieldBuilder
            ->setName($name)
            ->setPresentation($presentation)
            ->setType($type)
        ;
    }

    /**
     * Add field.
     * 
     * @param $name
     * @param $presentation
     * @param $type
     * @return PrototypeBuilder
     */
    public function addField($name, $presentation, $type)
    {
        $this->assertNotPersisted();

        $field = $this->createField($name, $presentation, $type);

        return $this;
    }

    /**
     * Remove field.
     * 
     * @param string $name
     * @return PrototypeBuilder
     */
    public function removeField($name)
    {
        $this->assertNotPersisted();

        if ($this->hasField($name)) {
            unset($this->fields[$name]);
        }

        return $this;
    }

    /**
     * Get prototype.
     * 
     * @return Prototype
     */
    public function getPrototype()
    {
        return $this->prototype;
    }

    /**
     * Get model class.
     * 
     * @return string
     */
    public function getModelClass()
    {
        return $this->fixtureManager->resolveClassFromParameter(
            sprintf('accard.model.%s_prototype.class', $this->subject)
        );
    }

    /**
     * Get field model class.
     * 
     * @return string
     */
    public function getFieldModelClass()
    {
        return $this->fixtureManager->resolveClassFromParameter(
            sprintf('accard.model.%s_field.class', $this->subject)
        );
    }

    /**
     * 
     * @return string
     */
    public function getFieldValueModelClass()
    {
        return $this->fixtureManager->resolveClassFromParameter(
            sprintf('accard.model.%s.field_value.class', $this->subject)
        );
    }

    /**
     * End and persist
     * 
     * @return PrototypeBuilder
     */
    public function end()
    {
        if (!$this->persisted) {
            foreach ($this->fields as $field) {
                $this->prototype->addField($field->getField());
            }
        }

        return $this;
    }

    /**
     * Persist prototype
     */
    public function persist()
    {
        $this->end();
        $this->persisted = true;
        $this->fixtureManager->objectManager->persist($this->prototype);
    }

    /**
     * Assert not persisted
     * 
     * @return boolean
     */
    private function assertNotPersisted()
    {
        if ($this->persisted) {
            throw new \Exception('Prototype builder has already been persisted.');
        }
    }
}
