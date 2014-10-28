<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Field\Model;

use Doctrine\Common\Collections\Collection;

/**
 * Field subject trait.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait FieldSubjectTrait
{
    /**
     * Fields.
     *
     * @var Collection|FieldValueInterface[]
     */
    protected $fields;


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
    public function addField(FieldValueInterface $field)
    {
        if (!$this->hasField($field)) {
            $field->setSubject($this);
            $this->fields->add($field);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeField(FieldValueInterface $field)
    {
        if ($this->hasField($field)) {
            $this->fields->removeElement($field);
            $field->setSubject(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasField(FieldValueInterface $field)
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
