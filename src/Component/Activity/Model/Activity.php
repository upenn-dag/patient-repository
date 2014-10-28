<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Model;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;
use Accard\Component\Prototype\Model\PrototypeInterface as BasePrototypeInterface;


/**
 * Accard activity model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Activity implements ActivityInterface
{
    use \Accard\Component\Prototype\Model\PrototypeSubjectTrait;

    /**
     * Activity id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Activity date.
     *
     * @var DateTime
     */
    protected $activityDate;

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
    public function getActivityDate()
    {
        return $this->activityDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setActivityDate(DateTime $activityDate)
    {
        $this->activityDate = $activityDate;

        return $this;
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
            $field->setActivity($this);
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
            $field->setActivity(null);
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

    public function getCanonical()
    {
        $canonical = 'Activity';

        if ($this->activityDate) {
            $canonical .= ' on '.$this->activityDate->format('d/m/Y');
        }

        return $canonical;
    }

    public function __toString()
    {
        return $this->getCanonical();
    }
}
