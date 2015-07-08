<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Model;

use DateTime;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Activity\Model\Activity;
use Accard\Component\Field\Test\FieldSubjectTest;

/**
 * Activity model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityTest extends Test
{
    use FieldSubjectTest;

    protected function _before()
    {
        $this->activityDate = new DateTime('2010-1-1 00:00:00');
        $this->prototype = Mockery::mock('Accard\Component\Activity\Model\PrototypeInterface');
        $this->drug = Mockery::mock('Accard\Component\Drug\Model\DrugInterface');
        $this->activity = new Activity();

        // Required by field subject test trait above.
        $this->fieldSubject = $this->activity;
    }

    public function testActivityInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Activity\Model\ActivityInterface',
            $this->activity
        );
    }

    public function testActivityIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->activity
        );
    }

    public function testActivityIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->activity);
        $this->assertNull($this->activity->getId());
    }

    public function testActivityDateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'activityDate', $this->activity);
        $this->assertNull($this->activity->getActivityDate());
    }

    public function testActivityDateIsMutable()
    {
        $this->activity->setActivityDate($this->activityDate);
        $this->assertAttributeSame($this->activityDate, 'activityDate', $this->activity);
        $this->assertSame($this->activityDate, $this->activity->getActivityDate());
    }

    public function testActivityDrugIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'drug', $this->activity);
        $this->assertNull($this->activity->getDrug());
    }

    public function testActivityDrugIsMutable()
    {
        $this->activity->setDrug($this->drug);
        $this->assertAttributeSame($this->drug, 'drug', $this->activity);
        $this->assertSame($this->drug, $this->activity->getDrug());
    }

    public function testActivityDrugIsNullable()
    {
        $this->activity->setDrug(null);
        $this->assertAttributeSame(null, 'drug', $this->activity);
    }

    public function testActivityObjectIsStringable()
    {
        $this->assertInternalType('string', (string) $this->activity);
    }

    // Derived data...

    public function testActivityIsNotDruggableByDefault()
    {
        $this->assertFalse($this->activity->isDruggable());
    }

    public function testActivityIsDruggaleWhenPrototypeAllowsIt()
    {
        $this->setupDruggablePrototype(true);
        $this->assertTrue($this->activity->isDruggable());
    }

    public function testActivityIsNotDruggableWhenPrototypeDoesNotAllowIt()
    {
        $this->setupDruggablePrototype(false);
        $this->assertFalse($this->activity->isDruggable());
    }


    // To be removed?

    public function testActivityReturnCanonicalDescriptionWithId()
    {
        $this->assertInternalType('string', $this->activity->getCanonical());
    }

    public function testActivityReturnCanonicalDescriptionWithDate()
    {
        $this->activity->setActivityDate($this->activityDate);
        $this->assertInternalType('string', $this->activity->getCanonical());
    }


    // Privates

    private function setupDruggablePrototype($druggable)
    {
        $this->prototype->shouldReceive('getAllowDrug')->once()->andReturn($druggable);
        $this->activity->setPrototype($this->prototype);
    }
}
