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
     * Get field configuration.
     *
     * @return array
     */
    public function getConfiguration();
}
