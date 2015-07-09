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

use DateTime;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Core\Model\PatientPhaseInstance;

/**
 * Patient phase model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientPhaseInstanceTest extends Test
{
    public function _before()
    {
        $this->date = new DateTime();
        $this->target = Mockery::mock('Accard\Component\Phase\Model\PhaseTargetInterface');
        $this->phase = Mockery::mock('Accard\Component\Core\Model\PatientPhaseInterface');
        $this->resource = new PatientPhaseInstance();
    }

    public function testPatientPhaseInstanceImplementsInterfaces()
    {
        $this->assertInstanceOf(
            'Accard\Component\Core\Model\PatientPhaseInstanceInterface',
            $this->resource
        );
    }

    public function testPatientPhaseIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->resource);
        $this->assertNull($this->resource->getId());
    }

    public function testPatientPhaseInstanceIdIsMutable()
    {
        $expected = 1;
        $this->assertSame($this->resource, $this->resource->setId($expected));
        $this->assertSame($expected, $this->resource->getId());
    }

    public function testPatientPhaseInstancePhaseIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'phase', $this->resource);
        $this->assertNull($this->resource->getPhase());
    }

    public function testPatientPhaseInstancePhaseIsMutable()
    {
        $expected = $this->phase;
        $this->assertSame($this->resource, $this->resource->setPhase($expected));
        $this->assertSame($expected, $this->resource->getPhase());
    }

    public function testPatientPhaseInstanceTargetIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'target', $this->resource);
        $this->assertNull($this->resource->getTarget());
    }

    public function testPatientPhaseInstanceTargetIsMutableAndNullable()
    {
        $expected = $this->target;
        $this->assertSame($this->resource, $this->resource->setTarget($expected));
        $this->assertSame($expected, $this->resource->getTarget());
        $this->resource->setTarget(null);
        $this->assertNull($this->resource->getTarget());
    }

    public function testPatientPhaseInstanceStartDateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'startDate', $this->resource);
        $this->assertNull($this->resource->getStartDate());
    }

    public function testPatientPhaseInstanceStartDateIsMutable()
    {
        $expected = $this->date;
        $this->assertSame($this->resource, $this->resource->setStartDate($expected));
        $this->assertSame($expected, $this->resource->getStartDate());
    }

    public function testPatientPhaseInstanceEndDateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'endDate', $this->resource);
        $this->assertNull($this->resource->getEndDate());
    }

    public function testPatientPhaseInstanceEndDateIsMutableAndNullable()
    {
        $expected = $this->date;
        $this->assertSame($this->resource, $this->resource->setEndDate($expected));
        $this->assertSame($expected, $this->resource->getEndDate());
        $this->resource->setEndDate(null);
        $this->assertNull($this->resource->getEndDate());
    }

    public function testPatientPhaseInstanceIsOngoingWithoutEndDate()
    {
        $this->assertTrue($this->resource->isOngoing());
    }

    public function testPatientPhaseInstanceIsNotOngoingWithEndDate()
    {
        $this->resource->setEndDate($this->date);
        $this->assertFalse($this->resource->isOngoing());
    }
}
