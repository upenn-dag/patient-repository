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
use Accard\Component\Resource\Model\ResourceInterface;

/**
 * Field subject interface.
 *
 * Implemented by object which may be characterized via fields.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldSubjectInterface extends ResourceInterface
{
    /**
     * Get all subject fields.
     *
     * @return Collection|FieldValueInterface[]
     */
    public function getFields();

    /**
     * Set all subject fields.
     *
     * @param Collection|FieldValueInterface[] $fields
     * @return FieldSubjectInterface
     */
    public function setFields(Collection $fields);

    /**
     * Add a field.
     *
     * @param FieldValueInterface $field
     * @return FieldSubjectInterface
     */
    public function addField(FieldValueInterface $field);

    /**
     * Remove a field.
     *
     * @param FieldValueInterface
     * @return FieldSubjectInterface
     */
    public function removeField(FieldValueInterface $field);

    /**
     * Test if a field is present.
     *
     * @param FieldValueInterface
     * @return boolean
     */
    public function hasField(FieldValueInterface $field);

    /**
     * Test if a field is present by name.
     *
     * @param string $fieldName
     * @return boolean
     */
    public function hasFieldByName($fieldName);

    /**
     * Get a field by name.
     *
     * @param string $fieldName
     * @return FieldValueInterface
     */
    public function getFieldByName($fieldName);
}
