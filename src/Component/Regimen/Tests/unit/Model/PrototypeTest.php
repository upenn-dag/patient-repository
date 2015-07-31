<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Regimen\Model;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Regimen\Model\Prototype;

/**
 * Regimen prototype tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PrototypeTest extends Test
{
    protected function _before()
    {
        $this->prototype = new Prototype();
    }

    public function testPrototypeAdheresToPrototypeInterface()
    {
        $this->assertInstanceOf('DAG\Component\Prototype\Model\Prototype', $this->prototype);
    }

    public function testPrototypeActivityPrototypesAreArrayCollectionOnCreation()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->prototype->getActivityPrototypes());
    }

    public function testPrototypeActivityPrototypesCanAddActivityPrototypeInterface()
    {
        $activityPrototype = Mockery::mock('Accard\Component\Activity\Model\PrototypeInterface');

        $this->prototype->addActivityPrototype($activityPrototype);

        $this->assertEquals($this->prototype->getActivityPrototypes()->count(), 1);
    }

    public function testPrototypeActivityPrototypesAreUnique()
    {
        $activityPrototype = Mockery::mock('Accard\Component\Activity\Model\PrototypeInterface');

        $this->prototype->addActivityPrototype($activityPrototype);
        $this->prototype->addActivityPrototype($activityPrototype);

        $this->assertEquals($this->prototype->getActivityPrototypes()->count(), 1);
    }

    public function testPrototypeActivityPrototypesAreMultipleAddable()
    {
        $activityPrototype0 = Mockery::mock('Accard\Component\Activity\Model\PrototypeInterface');
        $activityPrototype1 = Mockery::mock('Accard\Component\Activity\Model\PrototypeInterface');

        $this->prototype->addActivityPrototype($activityPrototype0);
        $this->prototype->addActivityPrototype($activityPrototype1);

        $this->assertEquals($this->prototype->getActivityPrototypes()->count(), 2);
    }

    public function testPrototypeActivityPrototypesAreFindableWhenPresent()
    {
        $activityPrototype = Mockery::mock('Accard\Component\Activity\Model\PrototypeInterface');
        $this->prototype->addActivityPrototype($activityPrototype);

        $this->assertEquals($this->prototype->hasActivityPrototype($activityPrototype), true);
    }

    public function testPrototypeActivityPrototypesAreNotFindableWhenNotPresent()
    {
        $activityPrototype = Mockery::mock('Accard\Component\Activity\Model\PrototypeInterface');

        $this->assertEquals($this->prototype->hasActivityPrototype($activityPrototype), false);
    }

    public function testPrototypeActivityPrototypesAreRemovable()
    {
        $activityPrototype = Mockery::mock('Accard\Component\Activity\Model\PrototypeInterface');

        $this->prototype->addActivityPrototype($activityPrototype);
        $this->prototype->removeActivityPrototype($activityPrototype);

        $this->assertEquals($this->prototype->getActivityPrototypes()->count(), 0);
    }
}
