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
use Accard\Component\Core\Model\DiagnosisPhaseInstance;

/**
 * Diagnosis phase model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisPhaseInstanceTest extends Test
{
    public function _before()
    {
        $this->date = new DateTime();
        $this->target = Mockery::mock('Accard\Component\Phase\Model\PhaseTargetInterface');
        $this->phase = Mockery::mock('Accard\Component\Core\Model\DiagnosisPhaseInterface');
        $this->resource = new DiagnosisPhaseInstance();
    }

    public function testDiagnosisPhaseInstanceImplementsInterfaces()
    {
        $this->assertInstanceOf(
            'Accard\Component\Core\Model\DiagnosisPhaseInstanceInterface',
            $this->resource
        );
    }

    public function testDiagnosisPhaseIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->resource);
        $this->assertNull($this->resource->getId());
    }

    public function testDiagnosisPhaseInstanceIdIsMutable()
    {
        $expected = 1;
        $this->assertSame($this->resource, $this->resource->setId($expected));
        $this->assertSame($expected, $this->resource->getId());
    }

    public function testDiagnosisPhaseInstancePhaseIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'phase', $this->resource);
        $this->assertNull($this->resource->getPhase());
    }

    public function testDiagnosisPhaseInstancePhaseIsMutable()
    {
        $expected = $this->phase;
        $this->assertSame($this->resource, $this->resource->setPhase($expected));
        $this->assertSame($expected, $this->resource->getPhase());
    }

    public function testDiagnosisPhaseInstanceTargetIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'target', $this->resource);
        $this->assertNull($this->resource->getTarget());
    }

    public function testDiagnosisPhaseInstanceTargetIsMutableAndNullable()
    {
        $expected = $this->target;
        $this->assertSame($this->resource, $this->resource->setTarget($expected));
        $this->assertSame($expected, $this->resource->getTarget());
        $this->resource->setTarget(null);
        $this->assertNull($this->resource->getTarget());
    }

    public function testDiagnosisPhaseInstanceStartDateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'startDate', $this->resource);
        $this->assertNull($this->resource->getStartDate());
    }

    public function testDiagnosisPhaseInstanceStartDateIsMutable()
    {
        $expected = $this->date;
        $this->assertSame($this->resource, $this->resource->setStartDate($expected));
        $this->assertSame($expected, $this->resource->getStartDate());
    }

    public function testDiagnosisPhaseInstanceEndDateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'endDate', $this->resource);
        $this->assertNull($this->resource->getEndDate());
    }

    public function testDiagnosisPhaseInstanceEndDateIsMutableAndNullable()
    {
        $expected = $this->date;
        $this->assertSame($this->resource, $this->resource->setEndDate($expected));
        $this->assertSame($expected, $this->resource->getEndDate());
        $this->resource->setEndDate(null);
        $this->assertNull($this->resource->getEndDate());
    }

    public function testDiagnosisPhaseInstanceIsOngoingWithoutEndDate()
    {
        $this->assertTrue($this->resource->isOngoing());
    }

    public function testDiagnosisPhaseInstanceIsNotOngoingWithEndDate()
    {
        $this->resource->setEndDate($this->date);
        $this->assertFalse($this->resource->isOngoing());
    }
}
