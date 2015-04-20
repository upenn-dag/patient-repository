<?php
namespace AccardTest\Component\Behavior\Model;

/**
 * Behavior test
 * 
 * @author Dylan Pierce <dylan@booksmart.it>
 */
use Accard\Component\Behavior\Model\Behavior;
use DateTime;
use DateInterval;
use Doctrine\Common\Collections\ArrayCollection;

class BehaviorTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->behavior = new Behavior();
    }

    protected function _after()
    {
    }

    /**
     * Interface Tests
     */
    public function testBehaviorInterfaceIsFollowed()
    {
        $this->assertInstanceOf('Accard\Component\Behavior\Model\BehaviorInterface', $this->behavior);
    }

    public function testBehaviorIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->behavior
        );
    }

    /**
     * Behavior->id
     */
    public function testBehaviorIdIsUnsetOnCreation()
    {
        $this->assertNull($this->behavior->getId());
    }

    /**
     * Behavior->fields
     */
    public function testBehaviorFieldsIsArrayCollectionOnCreation()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->behavior->getFields());
    }
    /**
     * Behavior->startDate
     */
    public function testBehaviorStartDateIsMutable()
    {
        $startDate = new DateTime();
        $this->behavior->setStartDate($startDate);

        $this->assertAttributeEquals($startDate, 'startDate', $this->behavior);
        $this->assertEquals($startDate, $this->behavior->getStartDate());
    }

    /**
     * Behavior->endDate
     */
    public function testBehaviorEndDateIsMutable()
    {
        $endDate = new DateTime();
        $this->behavior->setEndDate($endDate);

        $this->assertAttributeEquals($endDate, 'endDate', $this->behavior);
        $this->assertEquals($endDate, $this->behavior->getEndDate());
    }

    /**
     * Behavior validators
     */
    public function testBehaviorIsStartDateReturnsTrueWhenStartDateIsBeforeEndDate()
    {
        $startDate = new DateTime();
        $endDate = new DateTime();
        $endDate->add(new DateInterval('P1D'));

        $this->behavior->setStartDate($startDate);
        $this->behavior->setEndDate($endDate);

        $this->assertEquals(True, $this->behavior->isAfterStartDate());
    }

    public function testBehaviorIsStartDateReturnsFalseWhenStartDateIsAfterEndDate()
    {
        $startDate = new DateTime();
        $endDate = new DateTime();
        $startDate->add(new DateInterval('P1D'));

        $this->behavior->setStartDate($startDate);
        $this->behavior->setEndDate($endDate);

        $this->assertEquals(False, $this->behavior->isAfterStartDate());
    }
}