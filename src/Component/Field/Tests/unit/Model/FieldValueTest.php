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
use Accard\Component\Field\Model\FieldTypes;
use Accard\Component\Field\Model\FieldValue;
use Accard\Component\Field\Model\FieldValueInterface;

/**
 * Field value model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValueTest extends \Codeception\TestCase\Test
{
    public function _before()
    {
        $this->option = Mockery::mock('Accard\Component\Option\Model\OptionInterface');
        $this->field = Mockery::mock('Accard\Component\Field\Model\FieldInterface')
            ->shouldReceive('getName')->zeroOrMoreTimes()->andReturn('NAME')
            ->shouldReceive('getPresentation')->zeroOrMoreTimes()->andReturn('PRESENTATION')
            ->shouldReceive('getType')->zeroOrMoreTimes()->andReturn(FieldTypes::TEXT) // Text is easiest.
            ->shouldReceive('getOption')->zeroOrMoreTimes()->andReturn($this->option)
            ->shouldReceive('getAllowMultiple')->zeroOrMoreTimes()->andReturn(false)
            ->shouldReceive('isAddable')->zeroOrMoretimes()->andReturn(false)
            ->shouldReceive('getConfiguration')->zeroOrMoreTimes()->andReturn(array())
            ->getMock();
        ;

        $this->fieldSubject = Mockery::mock('Accard\Component\Field\Model\FieldSubjectInterface');
        $this->fieldValue = new FieldValue();
    }

    public function testFieldValueInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Field\Model\FieldValueInterface',
            $this->fieldValue
        );
    }

    public function testFieldValueOptionValueCollectionIsInitializedAndEmptyOnCreation()
    {
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Collections\Collection',
            'optionValues',
            $this->fieldValue
        );
        $this->assertAttributeCount(0, 'optionValues', $this->fieldValue);
    }

    public function testFieldValueIdIsUnsetOnCreation()
    {
        $this->assertNull($this->fieldValue->getId());
    }

    public function testFieldValueSubjectIsMutable()
    {
        $this->fieldValue->setSubject($this->fieldSubject);
        $this->assertAttributeSame($this->fieldSubject, 'subject', $this->fieldValue);
        $this->assertSame($this->fieldSubject, $this->fieldValue->getSubject());
    }

    public function testFieldValueSubjectIsNullable()
    {
        $this->fieldValue->setSubject(null);
        $this->assertAttributeSame(null, 'subject', $this->fieldValue);
    }

    public function testFieldValueFieldIsMutable()
    {
        $this->fieldValue->setField($this->field);
        $this->assertAttributeSame($this->field, 'field', $this->fieldValue);
        $this->assertSame($this->field, $this->fieldValue->getField());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueGetValueThrowsIfNoFieldIsSet()
    {
        $this->fieldValue->getValue();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueSetValueThrowsIfNoFieldIsSet()
    {
        $this->fieldValue->setValue('TOKEN');
    }

    /**
     * @expectedException RuntimeException
     */
    public function testFieldValueThrowsWhenFieldTypeIsNotSet()
    {
        $field = $this->createFieldMock();
        $this->fieldValue->setField($field);
        $this->fieldValue->setValue('FAIL');
    }

    // The field value "getValue" method is very complex, and we need to test for
    // every use case on the way out... hence the abundance of tests below.

    public function testFieldValueCheckboxValueIsFalseByDefault()
    {
        $field = $this->createFieldMock(FieldTypes::CHECKBOX);
        $this->fieldValue->setField($field);

        $this->assertFalse($this->fieldValue->getValue());
    }

    public function testFieldValueCheckboxValueIsMutable()
    {
        $field = $this->createFieldMock(FieldTypes::CHECKBOX);
        $this->fieldValue->setField($field); // Checkboxes set the NUMBER property.
        $this->fieldValue->setValue(true);
        $this->assertAttributeSame(true, 'numberValue', $this->fieldValue);
        $this->assertSame(true, $this->fieldValue->getValue());
    }

    public function testFieldValueChoiceValueIsMutable()
    {
        // This should check option values?!
        $field = $this->createFieldMock(FieldTypes::CHOICE);
        $this->fieldValue->setField($field); // Choices set the OPTIONVALUE property.
        $this->fieldValue->setValue('CHOICE');
        $this->assertAttributeSame('CHOICE', 'optionValue', $this->fieldValue);
        $this->assertSame('CHOICE', $this->fieldValue->getValue());
    }

    public function testFieldValueDateValueIsMutable()
    {
        $field = $this->createFieldMock(FieldTypes::DATE);
        $this->fieldValue->setfield($field); // Dates set the DATE property.
        $date = new DateTime();
        $this->fieldValue->setValue($date);
        $this->assertAttributeSame($date, 'dateValue', $this->fieldValue);
        $this->assertSame($date, $this->fieldValue->getValue());
    }

    public function testFieldValueDatetimeValueIsMutable()
    {
        $field = $this->createFieldMock(FieldTypes::DATETIME);
        $this->fieldValue->setField($field); // Dates set the DATE property.
        $date = new DateTime();
        $this->fieldValue->setValue($date);
        $this->assertAttributeSame($date, 'dateValue', $this->fieldValue);
        $this->assertSame($date, $this->fieldValue->getValue());
    }

    public function testFieldValueNumberValueIsMutable()
    {
        $field = $this->createFieldMock(FieldTypes::NUMBER);
        $this->fieldValue->setField($field); // Number set the NUMBER property.
        $this->fieldValue->setValue(1);
        $this->assertAttributeSame(1, 'numberValue', $this->fieldValue);
        $this->assertSame(1, $this->fieldValue->getValue());
    }

    public function testFieldValuePercentageValueIsMutable()
    {
        $field = $this->createFieldMock(FieldTypes::PERCENTAGE);
        $this->fieldValue->setField($field); // Percentage sets the NUMBER property.
        $this->fieldValue->setValue(1);
        $this->assertAttributeSame(1, 'numberValue', $this->fieldValue);
        $this->assertSame(1, $this->fieldValue->getValue());
    }

    public function testFieldValueTextValueIsMutable()
    {
        $field = $this->createFieldMock(FieldTypes::TEXT);
        $this->fieldValue->setField($field); // Text sets the STRING property.
        $this->fieldValue->setValue('TEXT');
        $this->assertAttributeSame('TEXT', 'stringValue', $this->fieldValue);
        $this->assertSame('TEXT', $this->fieldValue->getValue());
    }


    // Proxy method tests.

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueNameProxyThrowsIfFieldIsNotSet()
    {
        $this->fieldValue->getName();
    }

    public function testFieldValueNameProxyReturnsFieldNameValue()
    {
        $this->fieldValue->setField($this->field);
        $this->assertSame('NAME', $this->fieldValue->getName());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValuePresentationProxyThrowsIfFieldIsNotSet()
    {
        $this->fieldValue->getPresentation();
    }

    public function testFieldValuePresentationProxyReturnsFieldPresentationValue()
    {
        $this->fieldValue->setField($this->field);
        $this->assertSame('PRESENTATION', $this->fieldValue->getPresentation());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueTypeProxyThrowsIfFieldIsNotSet()
    {
        $this->fieldValue->getType();
    }

    public function testFieldValueTypeProxyReturnsFieldTypeValue()
    {
        $this->fieldValue->setField($this->field);
        $this->assertSame(FieldTypes::TEXT, $this->fieldValue->getType());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueOptionProxyThrowsIfFieldIsNotSet()
    {
        $this->fieldValue->getOption();
    }

    public function testFieldValueOptionProxyReturnsFieldOptionValue()
    {
        $this->fieldValue->setField($this->field);
        $this->assertSame($this->option, $this->fieldValue->getOption());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueAllowMultipleProxyThrowsIfFieldIsNotSet()
    {
        $this->fieldValue->getAllowMultiple();
    }

    public function testFieldValueAllowMultipleProxyReturnsFieldAllowMultipleValue()
    {
        $this->fieldValue->setField($this->createMultiOptionField());
        $this->assertSame(true, $this->fieldValue->getAllowMultiple());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueAddableProxyThrowsIfFieldIsNotSet()
    {
        $this->fieldValue->isAddable();
    }

    public function testFieldValueAddableProxyReturnsAddableValue()
    {
        $this->fieldValue->setField($this->field);
        $this->assertSame(false, $this->fieldValue->isAddable());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueConfigurationProxyThrowsIfFieldIsNotSet()
    {
        $this->fieldValue->getConfiguration();
    }

    public function testFieldValueConfigurationProxyReturnsFieldConfigurationValue()
    {
        $this->fieldValue->setField($this->field);
        $this->assertSame(array(), $this->fieldValue->getConfiguration());
    }

    private function createFieldMock($type = null)
    {
        return Mockery::mock('Accard\Component\Field\Model\FieldInterface')
            ->shouldReceive('getType')
            ->zeroOrMoreTimes()
            ->andReturn($type)
            ->getMock();
    }


    // Multiple option values methods.

    public function testFieldValueMultiOptionsCanBeSetOnTheirOwn()
    {
        // This is one ugly test
        $optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $testIterator = new \ArrayIterator(array($optionValue));

        $collection = Mockery::mock('Doctrine\Common\Collections\Collection')
            ->shouldReceive('getIterator')->zeroOrMoretimes()->andReturn($testIterator)
            ->getMock();

        $this->fieldValue->setField($this->createMultiOptionField());
        $this->fieldValue->setValues($collection);
        $this->assertAttributeCount(1, 'optionValues', $this->fieldValue);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueMultiOptionsThrowsOnGetIfFieldIsNotSet()
    {
        $this->fieldValue->setField($this->field);
        $this->fieldValue->getValues();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueMultiOptionsThrowsOnAddIfFieldIsNotSet()
    {
        $optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $this->fieldValue->setField($this->field)->addValue($optionValue);
    }

    public function testFieldValueMultiOptionsInAddable()
    {
        $optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $this->fieldValue->setField($this->createMultiOptionField())->addValue($optionValue);
        $this->assertAttributeCount(1, 'optionValues', $this->fieldValue);
    }

    public function testFieldValueMultiOptionsAreNotAddedTwice()
    {
        $optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $this->fieldValue->setField($this->createMultiOptionField())->addValue($optionValue);
        $this->fieldValue->addValue($optionValue);
        $this->assertAttributeCount(1, 'optionValues', $this->fieldValue);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueMultiOptionsThrowsOnTestIfFieldIsNotSet()
    {
        $optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $this->fieldValue->setField($this->field)->hasValue($optionValue);
    }

    public function testFieldValueMultiOptionsAreNotFoundWhenNotPresent()
    {
        $optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $this->fieldValue->setField($this->createMultiOptionField());
        $this->assertFalse($this->fieldValue->hasValue($optionValue));
    }

    public function testFieldValueMultiOptionsAreFoundWhenPresent()
    {
        $optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $this->fieldValue->setField($this->createMultiOptionField())->addValue($optionValue);
        $this->assertTrue($this->fieldValue->hasValue($optionValue));
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFieldValueMultiOptionsThrowsOnRemoveIfFieldIsNotSet()
    {
        $optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $this->fieldValue->setField($this->field)->removeValue($optionValue);
    }

    public function testFieldValueMultiOptionsAreRemovable()
    {
        $optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $this->fieldValue->setField($this->createMultiOptionField())->addValue($optionValue);
        $this->fieldValue->removeValue($optionValue);
        $this->assertAttributeCount(0, 'optionValues', $this->fieldValue);
    }

    public function testFieldValueMultiOptionsReturnsCollection()
    {
        $this->fieldValue->setField($this->createMultiOptionField());
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $this->fieldValue->getValues());
    }

    private function createMultiOptionField()
    {
        return Mockery::mock('Accard\Component\Field\Model\FieldInterface')
            ->shouldReceive('getType')->zeroOrMoreTimes()->andReturn(FieldTypes::CHOICE)
            ->shouldReceive('getOption')->zeroOrMoreTimes()->andReturn($this->option)
            ->shouldReceive('getAllowMultiple')->zeroOrMoreTimes()->andReturn(true)
            ->getMock();
    }

    // String conversion test methods.

    public function testFieldValueStringConversionValueIsRepresented()
    {
        $this->fieldValue->setField($this->field);
        $this->assertInternalType('string', (string) $this->fieldValue);
        $this->assertEquals('', (string) $this->fieldValue);
    }

    public function testFieldValueStringConversionYieldsValue()
    {
        $this->fieldValue->setField($this->field);
        $this->fieldValue->setValue('VALUE');
        $this->assertEquals('VALUE', (string) $this->fieldValue);
    }
}
