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
use Accard\Component\Core\Model\Patient;

/**
 * Patient model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientTest extends TestCase
{
    public function _setupResource()
    {
        $this->resource = new Patient();
    }

    public function testPatientIsTimestampable()
    {
        $this->assertResourceTimestampable(true);
    }

    public function testPatientIsBlamable()
    {
        $this->assertResourceBlameable(true);
    }

    public function testPatientIsVersionable()
    {
        $this->assertResourceVersionable(true);
    }

    public function testPatientMultipleActivityCollection()
    {
        $this->assertMultipleResourceCollect('activity', 'activities');
    }

    public function testPatientMultipleAttributeCollection()
    {
        $this->assertMultipleResourceCollect('attribute', 'attributes');
    }

    public function testPatientMultipleBehaviorsCollection()
    {
        $this->assertMultipleResourceCollect('behavior', 'behaviors');
    }

    public function testPatientMultipleDiagnosesCollection()
    {
        $this->assertMultipleResourceCollect('diagnosis', 'diagnoses');
    }

    public function testPatientMultiplePhaseCollection()
    {
        $this->assertMultipleResourceCollect('phase', 'phases');
    }

    public function testPatientMultipleRegimenCollection()
    {
        $this->assertMultipleResourceCollect('regimen', 'regimens');
    }

    public function testPatientMultipleSampleCollection()
    {
        $this->assertMultipleResourceCollect('sample', 'samples');
    }
}
