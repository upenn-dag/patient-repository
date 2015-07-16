<?php
namespace AccardTest\Component\Regimen\Model;

/**
 * Regimen Model Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Component\Regimen\Model\Regimen;
use Accard\Component\Activity\Model\Activity;
use DateTime;
use Mockery;

class RegimenTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->regimen = new Regimen();
    }

    protected function _after()
    {
    }

    public function testRegimenFollowsRegimenInterface()
    {
        $this->assertInstanceOf('Accard\Component\Regimen\Model\RegimenInterface', $this->regimen);
    }

    public function testRegimenIdIsNullOnCreation()
    {
        $this->assertSame(null, $this->regimen->getId());
    }

    public function testRegimenStartDateIsMutable()
    {
        $startDate = new DateTime();

        $this->regimen->setStartDate($startDate);
        $this->assertSame($this->regimen->getStartDate(), $startDate);
    }

    public function testRegimenEndDateIsMutable()
    {
        $endDate = new DateTime();

        $this->regimen->setEndDate($endDate);
        $this->assertSame($this->regimen->getEndDate(), $endDate);
    }

    public function testRegimenDrugIsMutable()
    {
        $drug = Mockery::Mock('Accard\Component\Drug\Model\DrugInterface');

        $this->regimen->setDrug($drug);

        $this->assertSame($drug, $this->regimen->getDrug());
    }

    public function testRegimenIsDruggableReturnsFalseIfNoPrototypeAssigned()
    {
        $this->assertSame(false, $this->regimen->isDruggable());
    }

    public function testRegimenCallsPrototypesGetAllowDrugIfPrototypePresent()
    {
        $prototype = Mockery::mock('Accard\Component\Prototype\Model\PrototypeInterface');

        $this->regimen->setPrototype($prototype);

        $prototype->shouldReceive('getAllowDrug');
    }

    public function testRegimenActivitiesIsArrayCollectionOnCreation()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->regimen->getActivities());
    }

    public function testRegimenActivitiesCanAddAnActivity()
    {
        $activity = Mockery::mock('Accard\Component\Activity\Model\ActivityInterface');
        $activity->shouldReceive('setRegimen');
        $this->regimen->addActivity($activity);

        $this->assertSame($this->regimen->getActivities()->first(), $activity);

    }

    public function testRegimenActivitiesDoesNotAddTheSameActivityTwice()
    {
        $activity = Mockery::mock('Accard\Component\Activity\Model\ActivityInterface');
        $activity->shouldReceive('setRegimen')->once();

        $this->regimen->addActivity($activity);
        $this->regimen->addActivity($activity);

        $this->assertSame($this->regimen->getActivities()->count(), 1);
    }

    public function testRegimenActivitiesDoesNotContainActivityOnCreation()
    {
        $activity = Mockery::mock('Accard\Component\Activity\Model\ActivityInterface');

        $this->assertSame(false, $this->regimen->hasActivity($activity));
    }

    public function testRegimenActivitiesFindsActivityWhenPresent()
    {
        $activity = Mockery::mock('Accard\Component\Activity\Model\ActivityInterface');
        $activity->shouldReceive('setRegimen')->once();

        $this->regimen->addActivity($activity);

        $this->assertSame(true, $this->regimen->hasActivity($activity));
    }

    public function testRegimenCanAddMultipleActivities()
    {
        $activity0 = Mockery::mock('Accard\Component\Activity\Model\ActivityInterface');
        $activity0->shouldReceive('setRegimen')->once();
        $activity1 = Mockery::mock('Accard\Component\Activity\Model\ActivityInterface');
        $activity1->shouldReceive('setRegimen')->once();

        $this->regimen->addActivity($activity1);
        $this->regimen->addActivity($activity0);

        $this->assertEquals(2, $this->regimen->getActivities()->count());
        $this->assertEquals(true, $this->regimen->hasActivity($activity0));
        $this->assertEquals(true, $this->regimen->hasActivity($activity1));
    }

    public function testRegimenCanRemoveActivities()
    {
        $activity = Mockery::mock('Accard\Component\Activity\Model\ActivityInterface');
        $activity->shouldReceive('setRegimen')->twice();

        $this->regimen->addActivity($activity);
        $this->regimen->removeActivity($activity);

        $this->assertEquals(0, $this->regimen->getActivities()->count());
        $this->assertEquals(false, $this->regimen->hasActivity($activity));
    }

    public function testRegimenFieldsIsArrayCollectionOnCreation()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->regimen->getFields());
    }

    public function testRegimenToStringFormatsCorrectly()
    {
        $this->assertEquals("Regimen #", (string) $this->regimen);
    }
}