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
use Accard\Component\Field\Model\FieldSubjectInterface;
use Accard\Component\Option\Model\OptionValueInterface;
use Accard\Component\Resource\Model\ResourceInterface;

/**
 * Basic patient interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PatientInterface extends FieldSubjectInterface, ResourceInterface
{
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get MRN.
     *
     * @return mixed
     */
    public function getMRN();

    /**
     * Set MRN.
     *
     * @param mixed $mrn
     */
    public function setMRN($mrn);

    /**
     * Get first name.
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Set first name.
     *
     * @param string $firstName
     */
    public function setFirstName($firstName);

    /**
     * Get last name.
     *
     * @return string
     */
    public function getLastName();

    /**
     * Set last name.
     *
     * @param string $lastName
     */
    public function setLastName($lastName);

    /**
     * Get full name.
     *
     * @return string
     */
    public function getFullName();

    /**
     * Get date of birth.
     *
     * @return DateTime
     */
    public function getDateOfBirth();

    /**
     * Set date of birth.
     *
     * @param DateTime $dateOfBirth
     */
    public function setDateOfBirth(DateTime $dateOfBirth = null);

    /**
     * Get age.
     *
     * @return DateInterval|null
     */
    public function getAge();

    /**
     * Get date of death.
     *
     * @return DateTime
     */
    public function getDateOfDeath();

    /**
     * Set date of death.
     *
     * @param DateTime $dateOfDeath
     */
    public function setDateOfDeath(DateTime $dateOfDeath = null);

    /**
     * Test if deceased.
     *
     * @return boolean
     */
    public function isDeceased();

    /**
     * Get gender.
     *
     * @return OptionValueInterface
     */
    public function getGender();

    /**
     * Set gender
     *
     * @param OptionValueInterface $gender
     */
    public function setGender(OptionValueInterface $gender = null);

    /**
     * Get race.
     *
     * @return OptionValueInterface
     */
    public function getRace();

    /**
     * Set race.
     *
     * @return OptionValueInterface
     */
    public function setRace(OptionValueInterface $race = null);
}
