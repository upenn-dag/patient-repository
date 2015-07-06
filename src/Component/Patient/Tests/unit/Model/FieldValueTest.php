<?php
namespace AccardTest\Component\FieldValue\Model;

use Mockery;
use Accard\Component\Patient\Model\FieldValue;
use Accard\Component\Patient\Model\FieldValueInterface;

class FieldValueTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->field = Mockery::mock('Accard\Component\Patient\Model\FieldValueInterface');
        $this->field->shouldReceive('getSubject')->zeroOrMoreTimes()->andReturn('NAME');
       
        $this->fieldValue = new FieldValue();
    }

    protected function _after()
    {
    }

    /**
     * Interface tests
     */
    public function testFieldValueInterfaceIsFollowed()
    {

        $this->assertInstanceOf(
            'Accard\Component\Patient\Model\FieldValueInterface',
            $this->fieldValue
        );
    }


    public function testFieldValueIdIsUnsetOnCreation()
    {
        $this->assertNull($this->fieldValue->getId());
    }



}