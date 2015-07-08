<?php


/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Patient;

use Mockery;
use Codeception\TestCase\Test;

/**
 * Tests for presence of patient interfaces required by the API.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class InterfaceTest extends Test
{
    public function testPatientBuilderInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Patient\Builder\PatientBuilderInterface'));
    }

    public function testPatientExceptionInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Patient\Exception\PatientException'));
    }

    public function testPatientFieldInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Patient\Model\FieldInterface'));
    }

    public function testPatientFieldValueInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Patient\Model\FieldValueInterface'));
    }

    public function testPatientModelInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Patient\Model\PatientInterface'));
    }

    public function testPatientCollectingInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Patient\Model\PatientCollectingInterface'));
    }

    public function testPatientProviderInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Patient\Provider\PatientProviderInterface'));
    }

    public function testPatientRepositoryInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Patient\Repository\PatientRepositoryInterface'));
    }
}
