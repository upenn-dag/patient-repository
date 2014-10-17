<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PDS patient entity
 *
 * @ORM\Entity(readOnly=true, repositoryClass="Accard\Bundle\PDSBundle\Entity\PatientRepository")
 * @ORM\Table(name="PDS_MDM_PATIENT")
 *
 * @todo Turn "associated" data into separate entities.
 */
class Patient implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="pk_patient_id", type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="hup_mrn", type="integer")
     *
     * @var integer
     */
    protected $mrn;

    /**
     * @ORM\Column(name="soc_sec_no", type="integer")
     *
     * @var integer|null
     */
    protected $socialSecurityNumber;

    /**
     * @ORM\Column(name="patient_prefix", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $prefix;

    /**
     * @ORM\Column(name="patient_fname_standard", type="string")
     *
     * @var string
     */
    protected $firstName;

    /**
     * @ORM\Column(name="patient_mname", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $middleName;

    /**
     * @ORM\Column(name="patient_lname", type="string")
     *
     * @var string
     */
    protected $lastName;

    /**
     * @ORM\Column(name="patient_generation", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $generation;

    /**
     * @ORM\Column(name="patient_suffix", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $suffix;

    /**
     * @ORM\Column(name="gender_description", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $gender;

    /**
     * @ORM\Column(name="marital_status_description", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $maritalStatus;

    /**
     * @ORM\Column(name="race_description", type="string", nullable=false)
     *
     * @var string|null
     */
    protected $race;

    /**
     * @ORM\Column(name="race_hispanic_yn", type="boolean", nullable=true)
     *
     * @var boolean|null
     */
    protected $isHispanic;

    /**
     * @ORM\Column(name="race_mixed_description", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $raceMixed;

    /**
     * @ORM\Column(name="birth_date", type="datetime")
     *
     * @var \DateTime
     */
    protected $dateOfBirth;

    /**
     * @ORM\Column(name="deceased_date", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    protected $dateOfDeath;

    /**
     * @ORM\Column(name="address_1", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $address1;

    /**
     * @ORM\Column(name="address_2", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $address2;

    /**
     * @ORM\Column(name="city", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $city;

    /**
     * @ORM\Column(name="state", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $state;

    /**
     * @ORM\Column(name="zip", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $zip;

    /**
     * @ORM\Column(name="home_phone", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $homePhone;

    /**
     * @ORM\Column(name="work_phone", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $workPhone;

    /**
     * @ORM\Column(name="mobile_phone", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $mobilePhone;

    /**
     * @ORM\Column(name="email", type="string", nullable=true)
     *
     * @var string|null
     */
    protected $email;

    /**
     * @ORM\Column(name="mdm_last_update_date", type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\Encounter", mappedBy="patient")
     **/
    protected $encounters;

    /**
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\Order", mappedBy="patient")
     **/
    protected $orders;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMRN()
    {
        return str_pad($this->mrn, 9, "0", STR_PAD_LEFT);
    }

    /**
     * @return integer|null
     */
    public function getSocialSecurityNumber()
    {
        return $this->socialSecurityNumber;
    }

    /**
     * @return string|null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getGeneration()
    {
        return $this->generation;
    }

    /**
     * @return string|null
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @return string|null
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return string|null
     */
    public function getMaritalStatus()
    {
        return $this->maritalStatus;
    }

    /**
     * @return string|null
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @return boolean|null
     */
    public function isHispanic()
    {
        return $this->isHispanic;
    }

    /**
     * @return string|null
     */
    public function getRaceMixed()
    {
        return $this->raceMixed;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateOfDeath()
    {
        return $this->dateOfDeath;
    }

    /**
     * @return boolean
     */
    public function isDeceased()
    {
        return null !== $this->dateOfDeath;
    }

    /**
     * @return string|null
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @return string|null
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string|null
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @return string|null
     */
    public function getHomePhone()
    {
        return $this->homePhone;
    }

    /**
     * @return string|null
     */
    public function getWorkPhone()
    {
        return $this->workPhone;
    }

    /**
     * @return string|null
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @return Encounter[]
     */
    public function getEncounters()
    {
        return $this->encounters;
    }

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }

    public function jsonSerialize()
    {
        $dateFormat = "F d, Y G:i:s";
        $dateOfBirth = $this->getDateOfBirth();
        $dateOfDeath = $this->getDateOfDeath();
        $dateOfUpdate = $this->getLastModified();

        return array(
            "mrn" => $this->getMRN(),
            "social_security_number" => $this->getSocialSecurityNumber(),
            "prefix" => $this->getPrefix(),
            "first_name" => $this->getFirstName(),
            "middle_name" => $this->getMiddleName(),
            "last_name" => $this->getLastName(),
            "generation" => $this->getGeneration(),
            "suffix" => $this->getSuffix(),
            "gender" => $this->getGender(),
            "marital_status" => $this->getMaritalStatus(),
            "race" => $this->getRace(),
            "is_hispanic" => $this->isHispanic(),
            "race_mixed" => $this->getRaceMixed(),
            "is_deceased" => $this->isDeceased(),
            "date_of_birth" => $dateOfBirth ? $dateOfBirth->format($dateFormat) : null,
            "date_of_death" => $dateOfDeath ? $dateOfDeath->format($dateFormat) : null,
            "address_1" => $this->getAddress1(),
            "address_2" => $this->getAddress2(),
            "city" => $this->getCity(),
            "state" => $this->getState(),
            "zip" => $this->getZip(),
            "home_phone" => $this->getHomePhone(),
            "work_phone" => $this->getWorkPhone(),
            "mobile_phone" => $this->getMobilePhone(),
            "email" => $this->getEmail(),
            "last_modified" => $dateOfUpdate ? $dateOfUpdate->format($dateFormat) : null,
        );
    }
}
