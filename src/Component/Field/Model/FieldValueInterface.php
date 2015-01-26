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
use Accard\Component\Option\Model\OptionInterface;
use Accard\Component\Option\Model\OptionValueInterface;

/**
 * Field value interface.
 *
 * This model associates the field with its value on the object.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldValueInterface
{
    /**
     * Get subject.
     *
     * @return FieldSubjectInterface
     */
    public function getSubject();

    /**
     * Set subject.
     *
     * @param FieldSubjectInterface|null $subject
     * @return FieldValueInterface
     */
    public function setSubject(FieldSubjectInterface $subject = null);

    /**
     * Get field.
     *
     * @return FieldInterface
     */
    public function getField();

    /**
     * Set field.
     *
     * @param FieldInterface $field
     * @return FieldValueInterface
     */
    public function setField(FieldInterface $field);

    /**
     * Get value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Set value.
     *
     * @param mixed $value
     * @return FieldValueInterface
     */
    public function setValue($value);

    /**
     * Get values.
     *
     * @return Collection|OptionValueInterface[]
     */
    public function getValues();

    /**
     * Set values.
     *
     * @param Collection|OptionValueInterface[]
     * @return FieldValueInterface
     */
    public function setValues(Collection $values);

    /**
     * Test for presence of value.
     *
     * @param OptionValueInterface $value
     * @return FieldValueInterface
     */
    public function hasValue(OptionValueInterface $value);

    /**
     * Add value.
     *
     * @param OptionValueInterface $value
     * @return FieldValueInterface
     */
    public function addValue(OptionValueInterface $value);

    /**
     * Remove value.
     *
     * @param OptionValueInterface $value
     * @return FieldValueInterface
     */
    public function removeValue(OptionValueInterface $value);

    /**
     * Proxy access to name on field.
     *
     * @return string
     */
    public function getName();

    /**
     * Proxy access to presentation on field.
     *
     * @return string
     */
    public function getPresentation();

    /**
     * Proxy access to type on field.
     *
     * @return string
     */
    public function getType();

    /**
     * Proxy access to option on field.
     *
     * @return OptionInterface|null
     */
    public function getOption();

    /**
     * Proxy access to multiplicity on field.
     *
     * @return boolean
     */
    public function getAllowMultiple();

    /**
     * Proxy access to addablity flag on field.
     *
     * @return boolean
     */
    public function isAddable();

    /**
     * Get field configuration.
     *
     * @return array
     */
    public function getConfiguration();
}
