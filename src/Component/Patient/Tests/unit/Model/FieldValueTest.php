<?php
namespace AccardTest\Component\FieldValue\Model;

use Mockery;
use Accard\Component\Option\Model\FieldValue;
use Accard\Component\Option\Model\FieldValueInterface;

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

    public function testFieldValueIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->fieldValue
        );
    }

    public function testFieldValueIsResourceLockable()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\LockableInterface',
            $this->fieldValue
        );
    }

    public function testFieldValueIdIsUnsetOnCreation()
    {
        $this->assertNull($this->fieldValue->getId());
    }

    public function testFieldAssociationIsMutable()
    {
        $this->fieldValue->setField($this->field);
        $this->assertAttributeSame($this->field, 'field', $this->fieldValue);
        $this->assertSame($this->field, $this->fieldValue->getField());
    }

    public function testFieldValueValuePropertyIsMutable()
    {
        $this->fieldValue->setPatient('NAME');
        $this->assertAttributeSame('NAME', 'name', $this->fieldValue);
        $this->assertSame('NAME', $this->fieldValue->getPatient());
    }

    public function testFieldValueFluency()
    {
        $this->assertSame($this->fieldValue, $this->fieldValue->setPatient('VALUE'));
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldNameProxyThrowsIfOptionIsNotSet()
    {
        $this->fieldValue->getPatient();
    }

    public function testFieldValueStringConversionValueIsRepresented()
    {
        $this->assertInternalType('string', (string) $this->fieldValue);
        $this->assertEquals('', (string) $this->fieldValue);
    }



}