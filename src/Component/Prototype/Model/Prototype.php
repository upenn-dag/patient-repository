<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Prototype\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Field\Model\FieldInterface;

/**
 * Prototype model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Prototype implements PrototypeInterface
{
    /**
     * Prototype id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Prototype name.
     *
     * @var string
     */
    protected $name;

    /**
     * Presentation name.
     *
     * @var string
     */
    protected $presentation;

    /**
     * Prototype subjects.
     *
     * @var Collection|PrototypeSubjectInterface[]
     */
    protected $subjects;

    /**
     * Fields.
     *
     * @var Collection|FieldInterface[]
     */
    protected $fields;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->subjects = new ArrayCollection();
        $this->fields = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
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
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * {@inheritdoc}
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubjects(Collection $subjects)
    {
        $this->subjects = $subjects;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addSubject(PrototypeSubjectInterface $subject)
    {
        if (!$this->hasSubject($subject)) {
            $subject->setPrototype($this);
            $this->subjects->add($subject);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSubject(PrototypeSubjectInterface $subject)
    {
        if ($this->hasSubject($subject)) {
            $this->subjects->removeElement($subject);
            $subject->setPrototype(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasSubject(PrototypeSubjectInterface $subject)
    {
        return $this->subjects->contains($subject);
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * {@inheritdoc}
     */
    public function setFields(Collection $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addField(FieldInterface $field)
    {
        if (!$this->hasField($field)) {
            $this->fields->add($field);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeField(FieldInterface $field)
    {
        if ($this->hasField($field)) {
            $this->fields->removeElement($field);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasField(FieldInterface $field)
    {
        return $this->fields->contains($field);
    }

    /**
     * {@inheritdoc}
     */
    public function hasFieldByName($fieldName)
    {
        foreach ($this->fields as $field) {
            if ($fieldName === $field->getName()) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldByName($fieldName)
    {
        foreach ($this->fields as $field) {
            if ($fieldName === $field->getName()) {
                return $field;
            }
        }
    }
}
