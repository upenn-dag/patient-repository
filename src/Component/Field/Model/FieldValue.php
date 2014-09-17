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

use BadMethodCallException;
use DateTime;

/**
 * Accard field to subject relationship.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValue implements FieldValueInterface
{
    /**
     * Field id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Field subject.
     *
     * @var FieldSubjectInterface
     */
    protected $subject;

    /**
     * Field.
     *
     * @var FieldInterface
     */
    protected $field;

    /**
     * Field string value.
     *
     * @var string|null
     */
    protected $stringValue;

    /**
     * Field date value.
     *
     * @var DateTime|null
     */
    protected $dateValue;

    /**
     * Field number value.
     *
     * @var integer|null
     */
    protected $numberValue;

    /**
     * Field choice value.
     *
     * @var OptionValue
     */
    protected $optionValue;


    /**
     * Get field id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject(FieldSubjectInterface $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * {@inheritdoc}
     */
    public function setField(FieldInterface $field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        if ($this->field && FieldTypes::CHECKBOX === $this->field->getType()) {
            return (boolean) $this->numberValue;
        }

        switch ($this->field->getType()) {
            case FieldTypes::NUMBER:
            case FieldTypes::PERCENTAGE:
                return $this->numberValue;
                break;
            case FieldTypes::CHOICE:
                return $this->optionValue;
                break;
            case FieldTypes::TEXT:
                return $this->stringValue;
                break;
            case FieldTypes::DATE:
            case FieldTypes::DATETIME:
                return $this->dateValue;
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        switch ($this->field->getType()) {
            case FieldTypes::CHECKBOX:
            case FieldTypes::NUMBER:
            case FieldTypes::PERCENTAGE:
                $this->numberValue = $value;
                break;
            case FieldTypes::CHOICE:
                $this->optionValue = $value;
                break;
            case FieldTypes::TEXT:
                $this->stringValue = $value;
                break;
            case FieldTypes::DATE:
            case FieldTypes::DATETIME:
                $this->dateValue = $value;
                break;
            case null:
            default:
                throw new \RuntimeException('Type must be set');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $this->assertFieldIsSet();

        return $this->field->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        $this->assertFieldIsSet();

        return $this->field->getPresentation();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        $this->assertFieldIsSet();

        return $this->field->getType();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        $this->assertFieldIsSet();

        return $this->field->getConfiguration();
    }

    /**
     * Test if field is set.
     *
     * @throws BadMethodCallException When field is not set
     */
    protected function assertFieldIsSet()
    {
        if (null === $this->field) {
            throw new BadMethodCallException('The field is undefined, so you cannot access proxy methods.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->value;
    }
}
