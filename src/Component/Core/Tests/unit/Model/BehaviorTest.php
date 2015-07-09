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
use Accard\Component\Core\Model\Behavior;

/**
 * Behavior model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BehaviorTest extends TestCase
{
    public function _setupResource()
    {
        $this->resource = new Behavior();
    }

    public function testBehaviorIsTimestampable()
    {
        $this->assertResourceTimestampable(true);
    }

    public function testBehaviorIsBlamable()
    {
        $this->assertResourceBlameable(true);
    }

    public function testBehaviorIsVersionable()
    {
        $this->assertResourceVersionable(true);
    }

    public function testBehaviorPatientCollection()
    {
        $this->assertResourceCollect('patient');
    }
}
