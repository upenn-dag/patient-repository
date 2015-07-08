<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Core;

use Mockery;
use Codeception\TestCase\Test;

/**
 * Interface tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class InterfaceTest extends Test
{
    public function testCoreActivityInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\ActivityInterface'));
    }

    public function testCoreAttributeInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\AttributeInterface'));
    }

    public function testCoreBehaviorInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\BehaviorInterface'));
    }

    public function testCoreDiagnosisInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\DiagnosisInterface'));
    }

    public function testCoreDiagnosisPhaseInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\DiagnosisPhaseInterface'));
    }

    public function testCoreDiagnosisPhaseInstanceInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\DiagnosisPhaseInstanceInterface'));
    }

    public function testCorePatientInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\PatientInterface'));
    }

    public function testCorePatientPhaseInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\PatientPhaseInterface'));
    }

    public function testCorePatientPhaseInstanceInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\PatientPhaseInstanceInterface'));
    }

    public function testCorePhaseInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\PhaseInterface'));
    }

    public function testCoreRegimenInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\RegimenInterface'));
    }

    public function testCoreSampleInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\SampleInterface'));
    }

    public function testCoreSourceInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Core\Model\SourceInterface'));
    }
}
