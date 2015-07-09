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
use Codeception\TestCase\Test;
use Accard\Component\Core\Model\PatientPhase;

/**
 * Patient phase model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientPhaseTest extends Test
{
    public function _before()
    {
        $this->resource = new PatientPhase();
    }

    public function testPatientPhaseImplementsInterfaces()
    {
        $this->assertInstanceOf(
            'Accard\Component\Core\Model\PhaseInterface',
            $this->resource
        );

        $this->assertInstanceOf(
            'Accard\Component\Core\Model\PatientPhaseInterface',
            $this->resource
        );
    }
}
