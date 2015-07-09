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
use Accard\Component\Core\Model\ImportActivity;

/**
 * ImportActivity model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportActivityTest extends TestCase
{
    public function _setupResource()
    {
        $this->resource = new ImportActivity();
    }

    public function testImportActivityPatientCollection()
    {
        $this->assertResourceCollect('patient');
    }

    public function testImportActivityDiagnosisCollection()
    {
        $this->assertResourceCollect('diagnosis');
    }
}
