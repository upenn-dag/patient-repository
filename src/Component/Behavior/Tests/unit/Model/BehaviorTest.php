<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Behavior\Model;

use DateTime;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Behavior\Model\Behavior;
use Accard\Component\Field\Test\FieldSubjectTest;

/**
 * Behavior model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BehaviorTest extends Test
{
    use FieldSubjectTest;

    protected function _before()
    {
        $this->behaviorStartDate = new DateTime('1970-01-01 00:00:00');
        $this->behaviorEndDate = new DateTime('1980-01-01 00:00:00');
        $this->behavior = new Behavior();

        // Required by field subject test trait above.
        $this->fieldSubject = $this->behavior;
    }

    public function testBehaviorInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Behavior\Model\BehaviorInterface',
            $this->behavior
        );
    }

    public function testBehaviorIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->behavior
        );
    }

    public function testBehaviorIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->behavior);
        $this->assertNull($this->behavior->getId());
    }

    public function testBehaviorStartDateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'startDate', $this->behavior);
        $this->assertNull($this->behavior->getStartDate());
    }

    public function testBehaviorStartDateIsMutable()
    {
        $expected = $this->behaviorStartDate;
        $this->behavior->setStartDate($expected);
        $this->assertSame($expected, $this->behavior->getStartDate());
    }

    public function testBehaviorEndDateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'endDate', $this->behavior);
        $this->assertNull($this->behavior->getEndDate());
    }

    public function testBehaviorEndDateIsMutable()
    {
        $expected = $this->behaviorEndDate;
        $this->behavior->setEndDate($expected);
        $this->assertSame($expected, $this->behavior->getEndDate());
    }

    public function testBehaviorEndDateIsNullable()
    {
        $this->behavior->setEndDate(null);
        $this->assertNull($this->behavior->getEndDate());
    }

    public function testBehaviorDateTestIsTrueWithNoEndDate()
    {
        $this->assertTrue($this->behavior->isAfterStartDate());
    }

    public function testBehaviorDateTestIsTrueWithEndDateAfterStartDate()
    {
        $this->behavior->setStartDate($this->behaviorStartDate);
        $this->behavior->setEndDAte($this->behaviorEndDate);

        $this->assertTrue($this->behavior->isAfterStartDate());
    }

    public function testBehaviorDateTestIsFalseWithEndDateBeforeStartDate()
    {
        $this->behavior->setStartDate($this->behaviorEndDate);
        $this->behavior->setEndDate($this->behaviorStartDate);

        $this->assertFalse($this->behavior->isAfterStartDate());
    }
}
