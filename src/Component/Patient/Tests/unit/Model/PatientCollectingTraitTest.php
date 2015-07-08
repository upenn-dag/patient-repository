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

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Patient\Test\PatientCollectingSubject;

class PatientCollectingTraitTest extends Test
{
    public function _before()
    {
        $this->patient = Mockery::mock('Accard\Component\Patient\Model\PatientInterface');
        $this->patientCollector = new PatientCollectingSubject();
    }

    // Test only here since, internally, we will require this.
    public function testPatientCollectingSubjectImplementsInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Patient\Model\PatientCollectingInterface',
            $this->patientCollector
        );
    }

    public function testPatientCollectingSubjectPatientIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'patient', $this->patientCollector);
        $this->assertNull($this->patientCollector->getPatient());
    }

    public function testPatientCollectingSubjectPatientIsMutable()
    {
        $this->patientCollector->setPatient($this->patient);
        $this->assertAttributeSame($this->patient, 'patient', $this->patientCollector);
    }

    public function testPatientCollectingSubjectPatientIsNullable()
    {
        $this->patientCollector->setPatient(null);
        $this->assertAttributeSame(null, 'patient', $this->patientCollector);
    }
}
