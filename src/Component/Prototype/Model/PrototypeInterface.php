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
use Accard\Component\Field\Model\FieldInterface;
use Accard\Component\Resource\Model\ResourceInterface;

/**
 * Prototype interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PrototypeInterface extends ResourceInterface
{
    /**
     * Get prototype id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get prototype name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set prototype name.
     *
     * @param string $name
     * @return PrototypeInterface
     */
    public function setName($name);

    /**
     * Get presentation name.
     *
     * @return string
     */
    public function getPresentation();

    /**
     * Set presentation name.
     *
     * @param string $presentation
     * @return PrototypeInterface
     */
    public function setPresentation($presentation);

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get parsed description.
     *
     * @return string
     */
    public function getParsedDescription(PrototypeSubjectInterface $subject);

    /**
     * Set description.
     *
     * @param string|null $description
     * @return PrototypeInterface
     */
    public function setDescription($description = null);

    /**
     * Get all subjects.
     *
     * @return Collection|PrototypeSubjectInterface[]
     */
    public function getSubjects();

    /**
     * Set all subject.
     *
     * @param Collection|PrototypeSubjectInterface[]
     * @return PrototypeInterface
     */
    public function setSubjects(Collection $subjects);

    /**
     * Add a subject.
     *
     * @param PrototypeSubjectInterface $subject
     * @return PrototypeInterface
     */
    public function addSubject(PrototypeSubjectInterface $subject);

    /**
     * Remove a subject.
     *
     * @param PrototypeSubjectInterface
     * @return PrototypeInterface
     */
    public function removeSubject(PrototypeSubjectInterface $subject);

    /**
     * Test if a subject is present.
     *
     * @param PrototypeSubjectInterface
     * @return boolean
     */
    public function hasSubject(PrototypeSubjectInterface $subject);

    /**
     * Get fields.
     *
     * @return Collection|FieldInterface[]
     */
    public function getFields();

    /**
     * Set fields.
     *
     * @param Collection|FieldInterface[] $fields
     * @return PrototypeInterface
     */
    public function setFields(Collection $fields);

    /**
     * Add field.
     *
     * @param FieldInterface $field
     * @return PrototypeInterface
     */
    public function addField(FieldInterface $field);

    /**
     * Remove field.
     *
     * @param FieldInterface $field
     * @return PrototypeInterface
     */
    public function removeField(FieldInterface $field);

    /**
     * Test for presence of a field.
     *
     * @param FieldInterface $field
     * @return boolean
     */
    public function hasField(FieldInterface $field);

    /**
     * Test for presence of a field by name.
     *
     * @param string $fieldName
     * @return boolean
     */
    public function hasFieldByName($fieldName);

    /**
     * Get field by name.
     *
     * @param string $fieldname
     * @return FieldInterface|null
     */
    public function getFieldByName($fieldName);
}
