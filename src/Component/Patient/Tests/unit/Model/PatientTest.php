<?php
namespace AccardTest\Component\Patient\Model;
use Accard\Component\Patient\Model\Patient;


class PatientTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
         $this->patient = new Patient;
    }

    protected function _after()
    {
    }

    /**
     * Interface tests
     */
    public function testPatientInterfaceIsFollowed()
    {

        $this->assertInstanceOf(
            'Accard\Component\Patient\Model\PatientInterface',
            $this->patient
        );
    }

    public function testDiagnosisIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->patient
        );
    }

    /**
     * Patient->id
     */
    public function testPatientIdIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getId());
    }

    /**
     * Patient->mrn
     */
    public function testPatientMrnIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getMrn());
    }

    /**
     * Patient->firstName
     */
    public function testPatientFirstNameIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getFirstName());
    }

     /**
     * Patient->lastName
     */
    public function testPatientLastNameIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getLastName());
    }

     /**
     * Patient->gender
     */
    public function testPatientGenderIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getGender());
    }

     /**
     * Patient->race
     */
    public function testPatientRaceIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getRace());
    }

    /**
     * Patient->dateofBirth
     */
    public function testPatientDateOfBirthIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getDateOfBirth());
    }

    /**
     * Patient->dateofDeath
     */
    public function testPatientDateOfDeathIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getDateOfDeath());
    }

    /**
     * Patient->age
     */
    public function testPatientAgeUnsetOnCreation()
    {
        $this->assertNull($this->patient->getAge());
    }

   public function testPatientFieldsAreArrayCollectionOnCreation()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->patient->getFields());
    }


}