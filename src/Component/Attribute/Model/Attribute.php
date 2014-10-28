<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Attribute\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;
use Accard\Component\Prototype\Model\PrototypeInterface as BasePrototypeInterface;

/**
 * Accard attribute model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Attribute implements AttributeInterface
{
    use \Accard\Component\Prototype\Model\PrototypeSubjectTrait;

    /**
     * Attribute id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Fields.
     *
     * @var Collection|BaseFieldValueInterface[]
     */
    protected $fields;


    /**
     * Constructor.
     */
    public function __construct()
    {
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
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * {@inheritdoc}
     */
    public function setFields(Collection $fields)
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addField(BaseFieldValueInterface $field)
    {
        if (!$this->hasField($field)) {
            $field->setAttribute($this);
            $this->fields->add($field);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeField(BaseFieldValueInterface $field)
    {
        if ($this->hasField($field)) {
            $this->fields->removeElement($field);
            $field->setAttribute(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasField(BaseFieldValueInterface $field)
    {
        return $this->fields->contains($field);
    }

    /**
     * {@inheritdoc}
     */
    public function hasFieldByName($fieldName)
    {
        foreach ($this->fields as $field) {
            if ($field->getName() === $fieldName) {
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
            if ($field->getName() === $fieldName) {
                return $field;
            }
        }
    }
}
