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
use Accard\Component\Core\Model\Sample;

/**
 * Sample model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SampleTest extends TestCase
{
    public function _setupResource()
    {
        $this->resource = new Sample();
    }

//    public function testSampleIsTimestampable()
//    {
//        $this->assertResourceTimestampable(true);
//    }

//    public function testSampleIsBlamable()
//    {
//        $this->assertResourceBlameable(true);
//    }

//    public function testSampleIsVersionable()
//    {
//        $this->assertResourceVersionable(true);
//    }

    public function testSamplePatientCollection()
    {
        $this->assertResourceCollect('patient');
    }
}
