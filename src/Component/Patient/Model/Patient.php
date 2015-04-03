<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Patient\Model;

use DateTime;
use DateInterval;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;
use Accard\Component\Option\Model\OptionValueInterface;

/**
 * Accard patient model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Patient implements PatientInterface
{
    /**
     * Patient id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Medical record number.
     *
     * @var mixed
     */
    protected $mrn;

    /**
     * First name.
     *
     * @var string
     */
    protected $firstName;

    /**
     * Last name.
     *
     * @var string
     */
    protected $lastName;

    /**
     * Date of birth.
     *
     * @var DateTime
     */
    protected $dateOfBirth;

    /**
     * Date of death
     *
     * @var DateTime
     */
    protected $dateOfDeath;

    /**
     * Gender.
     *
     * @var OptionValueInterface
     */
    protected $gender;

    /**
     * Race.
     *
     * @var OptionValueInterface
     */
    protected $race;

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
    public function getMRN()
    {
        return $this->mrn;
    }

    /**
     * {@inheritdoc}
     */
    public function setMRN($mrn)
    {
        $this->mrn = $mrn;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFullName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * {@inheritdoc}
     */
    public function setDateOfBirth(DateTime $dateOfBirth = null)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAge()
    {
        if (null === $this->dateOfBirth) {
            return;
        }

        $endDate = $this->dateOfDeath ?: new DateTime();

        return $endDate->diff($this->dateOfBirth);
    }

    /**
     * {@inheritdoc}
     */
    public function getDateOfDeath()
    {
        return $this->dateOfDeath;
    }

    /**
     * {@inheritdoc}
     */
    public function setDateOfDeath(DateTime $dateOfDeath = null)
    {
        $this->dateOfDeath = $dateOfDeath;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isDeceased()
    {
        return $this->dateOfDeath && new DateTime() >= $this->dateOfDeath;
    }

    /**
     * {@inheritdoc}
     */
    public function isDateOfDeathValid()
    {
        if (null === $this->dateOfDeath) {
            return true;
        }

        return $this->dateOfDeath > $this->dateOfBirth;
    }

    /**
     * {@inheritdoc}
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * {@inheritdoc}
     */
    public function setGender(OptionValueInterface $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * {@inheritdoc}
     */
    public function setRace(OptionValueInterface $race = null)
    {
        $this->race = $race;

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
            $field->setPatient($this);
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
            $field->setPatient(null);
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
