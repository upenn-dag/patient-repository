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
use Accard\Component\Core\Model\Regimen;

/**
 * Regimen model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenTest extends TestCase
{
    public function _setupResource()
    {
        $this->resource = new Regimen();
    }

    public function testRegimenIsTimestampable()
    {
        $this->assertResourceTimestampable(true);
    }

    public function testRegimenIsBlamable()
    {
        $this->assertResourceBlameable(true);
    }

    public function testRegimenIsVersionable()
    {
        $this->assertResourceVersionable(true);
    }

    public function testRegimenPatientCollection()
    {
        $this->assertResourceCollect('patient');
    }

    public function testRegimenDiagnosisCollection()
    {
        $this->assertResourceCollect('diagnosis');
    }
}
