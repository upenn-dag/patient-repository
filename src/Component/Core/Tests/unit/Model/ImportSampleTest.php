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
use Accard\Component\Core\Model\ImportSample;

/**
 * ImportSample model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportSampleTest extends TestCase
{
    public function _setupResource()
    {
        $this->resource = new ImportSample();
    }

    public function testImportSamplePatientCollection()
    {
        $this->assertResourceCollect('patient');
    }
}
