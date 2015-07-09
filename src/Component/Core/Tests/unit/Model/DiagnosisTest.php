<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Core\Model;

use Mockery;
use AccardTest\Component\Core\TestCase;
use Accard\Component\Core\Model\Diagnosis;

/**
 * Diagnosis model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisTest extends TestCase
{
    public function _setupResource()
    {
        $this->resource = new Diagnosis();
    }

    public function testDiagnosisShortcutToPatientFullName()
    {
        $expected = 'FIRST LAST';
        $patient = Mockery::mock('Accard\Component\Core\Model\PatientInterface')
            ->shouldReceive('getFullName')->once()->andReturn($expected)
            ->getMock();

        // Test null return without patient.
        $this->assertNull($this->resource->getPatientFullName());

        // Test name returns when set.
        $this->resource->setPatient($patient);
        $this->assertSame($expected, $this->resource->getPatientFullName());
    }

    public function testDiagnosisIsTimestampable()
    {
        $this->assertResourceTimestampable(true);
    }

    public function testDiagnosisIsBlamable()
    {
        $this->assertResourceBlameable(true);
    }

    public function testDiagnosisIsVersionable()
    {
        $this->assertResourceVersionable(true);
    }

    public function testDiagnosisPatientCollection()
    {
        $this->assertResourceCollect('patient');
    }

    public function testDiagnosisMultipleActivityCollection()
    {
        $this->assertMultipleResourceCollect('activity', 'activities');
    }

    public function testDiagnosisMultiplePhaseCollection()
    {
        $this->assertMultipleResourceCollect('phase', 'phases');
    }

    public function testDiagnosisMultipleRegimenCollection()
    {
        $this->assertMultipleResourceCollect('regimen', 'regimens');
    }
}
