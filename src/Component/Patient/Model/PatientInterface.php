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
use DAG\Component\Field\Model\FieldSubjectInterface;
use DAG\Component\Resource\Model\ResourceInterface;

/**
 * Basic patient interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PatientInterface extends FieldSubjectInterface, ResourceInterface
{
    /*
     * Gender constants.
     */
    const GENDER_MASCULINE = 'male';
    const GENDER_FEMININE = 'female';
    const GENDER_UNKNOWN = 'unknown';

    /*
     * Race constants.
     */
    const RACE_AMERICAN_NATIVE = 'american indian or alaska native';
    const RACE_ASIAN = 'asian';
    const RACE_BLACK = 'black or african american';
    const RACE_PACIFIC = 'native hawaiian or other pacific islander';
    const RACE_WHITE = 'white';
    const RACE_UNKNOWN = 'unknown';


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
     * @return string
     */
    public function getGender();

    /**
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender = null);

    /**
     * Get race.
     *
     * @return string
     */
    public function getRace();

    /**
     * Set race.
     *
     * @return string
     */
    public function setRace($race = null);
}
