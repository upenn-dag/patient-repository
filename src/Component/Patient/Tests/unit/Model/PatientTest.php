<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Patient\Model;

use DateTime;
use Codeception\TestCase\Test;
use Accard\Component\Patient\Model\Patient;
use Accard\Component\Field\Test\FieldSubjectTest;

class PatientTest extends Test
{
    use FieldSubjectTest;

    protected function _before()
    {
        $this->dateOfBirth = new DateTime('2010-1-1 00:00:00');
        $this->dateOfDeath = new DateTime('2015-1-1 00:00:00');
        $this->patient = new Patient();

        // Required by field subject test trait above.
        $this->fieldSubject = $this->patient;
    }

    public function testPatientInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Patient\Model\PatientInterface',
            $this->patient
        );
    }

    public function testPatientIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->patient
        );
    }

    public function testPatientDefinesAvailableGenders()
    {
        $this->assertInternalType('array', Patient::getAvailableGenders());
        $this->assertGreaterThan(0, count(Patient::getAvailableGenders()));
    }

    public function testPatientDefinesAvailableRaces()
    {
        $this->assertInternalType('array', Patient::getAvailableRaces());
        $this->assertGreaterThan(0, count(Patient::getAvailableRaces()));
    }

    public function testPatientIdIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getId());
    }

    public function testPatientMrnIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getMrn());
    }

    public function testPatientMrnIsMutable()
    {
        $this->patient->setMRN('MRN');
        $this->assertAttributeSame('MRN', 'mrn', $this->patient);
        $this->assertSame('MRN', $this->patient->getMRN());
    }

    public function testPatientFirstNameIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getFirstName());
    }

    public function testPatientFirstNameIsMutable()
    {
        $this->patient->setFirstName('FIRST_NAME');
        $this->assertAttributeSame('FIRST_NAME', 'firstName', $this->patient);
        $this->assertSame('FIRST_NAME', $this->patient->getFirstName());
    }

    public function testPatientLastNameIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getLastName());
    }

    public function testPatientLastNameIsMutable()
    {
        $this->patient->setLastName('LAST_NAME');
        $this->assertAttributeSame('LAST_NAME', 'lastName', $this->patient);
        $this->assertSame('LAST_NAME', $this->patient->getLastName());
    }

    public function testPatientGenderIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getGender());
    }

    public function testPatientGenderIsMutable()
    {
        $this->patient->setGender('GENDER');
        $this->assertAttributeSame('GENDER', 'gender', $this->patient);
        $this->assertSame('GENDER', $this->patient->getGender());
    }

    public function testPatientRaceIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getRace());
    }

    public function testPatientRaceIsMutable()
    {
        $this->patient->setRace('RACE');
        $this->assertAttributeSame('RACE', 'race', $this->patient);
        $this->assertSame('RACE', $this->patient->getRace());
    }

    public function testPatientDateOfBirthIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getDateOfBirth());
    }

    public function testPatientDateOfBirthIsMutableWithDate()
    {
        $this->patient->setDateOfBirth($this->dateOfBirth);
        $this->assertAttributeSame($this->dateOfBirth, 'dateOfBirth', $this->patient);
        $this->assertSame($this->dateOfBirth, $this->patient->getDateOfBirth());
    }

    public function testPatientDateOfBirthIsNullable()
    {
        $this->patient->setDateOfBirth(null);
        $this->assertAttributeSame(null, 'dateOfBirth', $this->patient);
    }

    public function testPatientDateOfDeathIsUnsetOnCreation()
    {
        $this->assertNull($this->patient->getDateOfDeath());
    }

    public function testPatientDateOfDeathIsMutableWithDate()
    {
        $this->patient->setDateOfDeath($this->dateOfDeath);
        $this->assertAttributeSame($this->dateOfDeath, 'dateOfDeath', $this->patient);
        $this->assertSame($this->dateOfDeath, $this->patient->getDateOfDeath());
    }

    public function testPatientDateOfDeathIsNullable()
    {
        $this->patient->setDateOfDeath(null);
        $this->assertAttributeSame(null, 'dateOfDeath', $this->patient);
    }


    // Derived field tests...

    public function testPatientFullNameFormat()
    {
        $this->patient->setFirstName('FIRST_NAME');
        $this->patient->setLastName('LAST_NAME');

        $this->assertSame('FIRST_NAME LAST_NAME', $this->patient->getFullName());
    }

    public function testPatientAgeIsNullWithoutDateOfBirth()
    {
        $this->assertNull($this->patient->getAge());
    }

    /**
     * Unable to calculate to perfect second, as execution time affects testing.
     */
    public function testPatientAgeCalculationForLivingPatient()
    {
        $this->patient->setDateOfBirth($this->dateOfBirth);
        $diff = (new DateTime())->diff($this->dateOfBirth);
        $age = $this->patient->getAge();

        // Unable to calculate to match time, execution time difference interferes.
        // Unless run at precisely midnight, this test is fine.
        $this->assertInstanceOf('DateInterval', $age);
        $this->assertEquals($age->y, $diff->y);
        $this->assertEquals($age->m, $diff->m);
        $this->assertEquals($age->d, $diff->d);
    }

    public function testPatientAgeCalculationForDeceasedPatient()
    {
        $this->patient->setDateOfBirth($this->dateOfBirth);
        $this->patient->setDateOfDeath($this->dateOfDeath);
        $diff = $this->dateOfDeath->diff($this->dateOfBirth);
        $age = $this->patient->getAge();

        // Same restrictions as testPatientAgeCalculationForLivingPatient
        $this->assertInstanceOf('DateInterval', $age);
        $this->assertEquals($age->y, $diff->y);
        $this->assertEquals($age->m, $diff->m);
        $this->assertEquals($age->d, $diff->d);
    }

    public function testPatientIsNotDeceasedWithoutDateOfDeath()
    {
        $this->assertFalse($this->patient->isDeceased());
    }

    public function testPatientIsDeceasedWithDateOfDeathPresent()
    {
        $this->patient->setDateOfDeath($this->dateOfDeath);
        $this->assertTrue($this->patient->isDeceased());
    }

    public function testPatientDateOfDeathIsValidWithNoDateOfDeath()
    {
        $this->assertTrue($this->patient->isDateOfDeathValid());
    }

    public function testPatientDateOfDeathIsValidIfAfterDateOfBirth()
    {
        $this->patient->setDateOfBirth($this->dateOfBirth);
        $this->patient->setDateOfDeath($this->dateOfDeath);

        $this->assertTrue($this->patient->isDateOfDeathValid());
    }

    public function testPatientDateOfDeathIsNotValidIfBeforeDateOfBirth()
    {
        $this->patient->setDateOfBirth($this->dateOfBirth);
        $this->patient->setDateOfDeath(new DateTime('1800-1-1 00:00:00'));

        $this->assertFalse($this->patient->isDateOfDeathValid());
    }

    public function testPatientFieldsAreArrayCollectionOnCreation()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->patient->getFields());
    }
}
