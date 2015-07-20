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

use DateTime;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Regimen\Model\Regimen;
use Accard\Component\Activity\Model\Activity;
use Accard\Component\Field\Test\FieldSubjectTest;

/**
 * Regimen model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenTest extends Test
{
    use FieldSubjectTest;

    protected function _before()
    {
        $this->regimen = new Regimen();
        $this->startDate = new DateTime('1970-01-01 00:00:00');
        $this->endDate = new DateTime('1980-01-01 00:00:00');
        $this->drug = Mockery::mock('Accard\\Component\\Drug\\Model\\DrugInterface');
        $this->activity = Mockery::mock('Accard\\Component\\Activity\\Model\\ActivityInterface')
            ->shouldReceive('setRegimen')->zeroOrMoreTimes()->andReturn(Mockery::self())
            ->getMock();

        // Required for field subject test trait.
        $this->fieldSubject = $this->regimen;
    }

    public function testRegimenFollowsRegimenInterface()
    {
        $this->assertInstanceOf('Accard\Component\Regimen\Model\RegimenInterface', $this->regimen);
    }

    public function testRegimenIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->regimen);
        $this->assertNull($this->regimen->getId());
    }

    public function testRegimenStartDateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'startDate', $this->regimen);
        $this->assertNull($this->regimen->getStartDate());
    }

    public function testRegimenStartDateIsMutable()
    {
        $expected = $this->startDate;
        $this->regimen->setStartDate($expected);
        $this->assertSame($expected, $this->regimen->getStartDate());
    }

    public function testRegimenStartDateSettingIsFluent()
    {
        $this->assertSame($this->regimen, $this->regimen->setStartDate($this->startDate));
    }

    public function testRegimenEndDateIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'endDate', $this->regimen);
        $this->assertNull($this->regimen->getEndDate());
    }

    public function testRegimenEndDateIsMutable()
    {
        $expected = $this->endDate;
        $this->regimen->setEndDate($expected);
        $this->assertSame($expected, $this->regimen->getEndDate());
    }

    public function testRegimenEndDateIsNullable()
    {
        $this->regimen->setEndDate(null);
        $this->assertNull($this->regimen->getEndDate());
    }

    public function testRegimenEndDateSettingIsFluent()
    {
        $this->assertSame($this->regimen, $this->regimen->setEndDate($this->endDate));
    }

    public function testRegimenDrugIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'drug', $this->regimen);
        $this->assertNull($this->regimen->getDrug());
    }

    public function testRegimenDrugIsMutable()
    {
        $expected = $this->drug;
        $this->regimen->setDrug($expected);
        $this->assertSame($expected, $this->regimen->getDrug());
    }

    public function testRegienIsNotDrugabbleWithoutPrototype()
    {
        $this->assertFalse($this->regimen->isDruggable());
    }

    public function testRegimenIsDruggableWhenPrototypeSaySo()
    {
        $prototype = Mockery::mock('Accard\\Component\\Regimen\\Model\\PrototypeInterface')
            ->shouldReceive('getAllowDrug')->once()->andReturn(true)
            ->getMock();

        $this->regimen->setPrototype($prototype);
        $this->assertTrue($this->regimen->isDruggable());
    }

    public function testRegimenIsNotDruggableWhenPrototypeSayNo()
    {
        $prototype = Mockery::mock('Accard\\Component\\Regimen\\Model\\PrototypeInterface')
            ->shouldReceive('getAllowDrug')->once()->andReturn(false)
            ->getMock();

        $this->regimen->setPrototype($prototype);
        $this->assertFalse($this->regimen->isDruggable());
    }

    public function testRegimenActivitiesAreAnEmptyCollectionOnCreation()
    {
        $this->assertAttributeInstanceOf('Doctrine\\Common\\Collections\\Collection', 'activities', $this->regimen);
        $this->assertAttributeEmpty('activities', $this->regimen);
        $this->assertInstanceOf('Doctrine\\Common\\Collections\\Collection', $this->regimen->getActivities());
        $this->assertEmpty($this->regimen->getActivities());
    }

    public function testRegimenActivityAdd()
    {
        $this->regimen->addActivity($this->activity);
        $this->assertCount(1, $this->regimen->getActivities());
    }

    public function testRegimenActivitesAreNotAddedTwice()
    {
        $this->regimen->addActivity($this->activity);
        $this->regimen->addActivity($this->activity);
        $this->assertCount(1, $this->regimen->getActivities());
    }

    public function testRegimenActivityAddIsFluent()
    {
        $this->assertSame($this->regimen, $this->regimen->addActivity($this->activity));
    }

    public function testRegimenActivityCanBeDetectedWhenPresent()
    {
        $this->regimen->addActivity($this->activity);
        $this->assertTrue($this->regimen->hasActivity($this->activity));
    }

    public function testRegimenActivityCanNotBeDetectedWhenNotPresent()
    {
        $this->assertFalse($this->regimen->hasActivity($this->activity));
    }

    public function testRegimenActivityRemove()
    {
        $this->regimen->addActivity($this->activity);
        $this->regimen->removeActivity($this->activity);
        $this->assertCount(0, $this->regimen->getActivities());
    }

    public function testRegimenActivityDoesNotRemoveNonRequestedActivities()
    {
        $regimen = Mockery::mock('Accard\\Component\\Activity\\Model\\ActivityInterface');
        $this->regimen->addActivity($this->activity);
        $this->regimen->removeActivity($regimen);
        $this->assertCount(1, $this->regimen->getActivities());
    }

    public function testRegimenToString()
    {
        $expected = 'Regimen #0';
        $this->assertSame($expected, (string) $this->regimen);
    }

    public function testRegimenDateCheckerReturnsTrueWhenNoEndDate()
    {
        $this->assertTrue($this->regimen->isAfterStartDate());
    }

    public function testRegimenDateCheckerReturnsTrueWhenEndDateGreaterThanStartDate()
    {
        $this->regimen->setStartDate($this->startDate);
        $this->regimen->setEndDate($this->endDate);
        $this->assertTrue($this->regimen->isAfterStartDate());
    }

    public function testRegimenDateCheckerReturnsFalseWhenEndDateBeforeStartDate()
    {
        $this->regimen->setStartDate($this->endDate);
        $this->regimen->setEndDate($this->startDate);
        $this->assertFalse($this->regimen->isAfterStartDate());
    }
}
