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

use Mockery;
use Accard\Component\Field\Model\FieldTypes;
use Accard\Component\Field\Model\Field;
use Accard\Component\Option\Model\OptionOrder;

/**
 * Field model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->field = new Field();
    }

    public function testFieldInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Field\Model\FieldInterface',
            $this->field
        );
    }

    public function testFieldIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->field
        );
    }

    public function testFieldIdIsUnsetOnCreation()
    {
        $this->assertNull($this->field->getId());
    }

    public function testFieldNameIsMutable()
    {
        $this->field->setName('NAME');
        $this->assertAttributeSame('NAME', 'name', $this->field);
        $this->assertSame('NAME', $this->field->getName());
    }

    public function testFieldPresentationIsMutable()
    {
        $this->field->setPresentation('PRESENTATION');
        $this->assertAttributeSame('PRESENTATION', 'presentation', $this->field);
        $this->assertSame('PRESENTATION', $this->field->getPresentation());
    }

    public function testFieldTypeIsTextByDefault()
    {
        $this->assertSame(FieldTypes::TEXT, $this->field->getType());
    }

    public function testFieldTypeIsMutable()
    {
        $this->field->setType('TYPE');
        $this->assertAttributeSame('TYPE', 'type', $this->field);
        $this->assertSame('TYPE', $this->field->getType());
    }

    public function testFieldOptionIsMutable()
    {
        $option = Mockery::mock('Accard\Component\Option\Model\OptionInterface');
        $this->field->setOption($option);
        $this->assertAttributeSame($option, 'option', $this->field);
        $this->assertSame($option, $this->field->getOption());
    }

    public function testFieldOptionIsNullable()
    {
        $this->field->setOption(null);
        $this->assertAttributeSame(null, 'option', $this->field);
    }

    public function testFieldAllowMultipleIsMutable()
    {
        $this->field->setAllowMultiple(true);
        $this->assertAttributeSame(true, 'allowMultiple', $this->field);
        $this->assertTrue($this->field->getAllowMultiple());
    }

    public function testFieldAllowMultipleIsFalseByDefault()
    {
        $this->assertFalse($this->field->getAllowMultiple());
    }

    public function testFieldAllowMultipleConvertsTruishValues()
    {
        $this->field->setAllowMultiple(1);
        $this->assertTrue($this->field->getAllowMultiple());
        $this->field->setAllowMultiple('true');
        $this->assertTrue($this->field->getAllowMultiple());
    }

    public function testFieldAddableIsMutable()
    {
        $this->field->setAddable(true);
        $this->assertAttributeSame(true, 'addable', $this->field);
        $this->assertTrue($this->field->isAddable());
    }

    public function testFieldAddableIsFalseByDefault()
    {
        $this->assertFalse($this->field->isAddable());
    }

    public function testFieldAddableCovertsTruishValues()
    {
        $this->field->setAddable(1);
        $this->assertTrue($this->field->isAddable());
        $this->field->setAddable('true');
        $this->assertTrue($this->field->isAddable());
    }

    public function testFieldConfigurationIsMutable()
    {
        $this->field->setConfiguration(array('test'));
        $this->assertAttributeSame(array('test'), 'configuration', $this->field);
        $this->assertSame(array('test'), $this->field->getConfiguration());
    }

    public function testFieldOrderingIsOrderingDefaultOnCreation()
    {
        $expected = OptionOrder::DEFAULT_ORDER;
        $this->assertAttributeSame($expected, 'order', $this->field);
        $this->assertSame($expected, $this->field->getOrder());
    }

    public function testFieldOrderingIsMutable()
    {
        $expected = OptionOrder::BY_ID_ASC;
        $this->field->setOrder($expected);
        $this->assertSame($expected, $this->field->getOrder());
    }

    public function testFieldConfigurationIsEmptyArrayByDefault()
    {
        $this->assertSame(array(), $this->field->getConfiguration());
    }

    public function testFieldStringConversionValueIsRepresented()
    {
        $this->assertInternalType('string', (string) $this->field);
        $this->assertEquals('', (string) $this->field);
    }

    public function testFieldStringConversionYieldsValue()
    {
        $this->field->setName('NAME');
        $this->assertEquals('NAME', (string) $this->field);
    }
}
