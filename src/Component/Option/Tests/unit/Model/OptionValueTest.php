<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Option\Model;

use Mockery;
use Accard\Component\Option\Model\OptionValue;
use Accard\Component\Option\Model\OptionValueInterface;

/**
 * Option value model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionValueTest extends \Codeception\TestCase\Test
{
    public function _before()
    {
        $this->option = Mockery::mock('Accard\Component\Option\Model\OptionInterface');
        $this->option->shouldReceive('getName')->zeroOrMoreTimes()->andReturn('NAME');
        $this->option->shouldReceive('getPresentation')->zeroOrMoreTimes()->andReturn('PRESENTATION');

        $this->optionValue = new OptionValue();
    }

    public function testOptionValueInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Option\Model\OptionValueInterface',
            $this->optionValue
        );
    }

    public function testOptionValueIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->optionValue
        );
    }

    public function testOptionValueIsResourceLockable()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\LockableInterface',
            $this->optionValue
        );
    }

    public function testOptionValueIsResourceOrderable()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\OrderableInterface',
            $this->optionValue
        );
    }

    public function testOptionValueIdIsUnsetOnCreation()
    {
        $this->assertNull($this->optionValue->getId());
    }

    public function testOptionAssociationIsMutable()
    {
        $this->optionValue->setOption($this->option);
        $this->assertAttributeSame($this->option, 'option', $this->optionValue);
        $this->assertSame($this->option, $this->optionValue->getOption());
    }

    public function testOptionValueValuePropertyIsMutable()
    {
        $this->optionValue->setValue('VALUE');
        $this->assertAttributeSame('VALUE', 'value', $this->optionValue);
        $this->assertSame('VALUE', $this->optionValue->getValue());
    }

    public function testOptionValueFluency()
    {
        $this->assertSame($this->optionValue, $this->optionValue->setValue('VALUE'));
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testOptionNameProxyThrowsIfOptionIsNotSet()
    {
        $this->optionValue->getName();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testOptionPresentationProxyThrowsIfOptionIsNotSet()
    {
        $this->optionValue->getPresentation();
    }

    public function testOptionValueProxyReturnsOptionNameValue()
    {
        $this->optionValue->setOption($this->option);
        $this->assertEquals('NAME', $this->optionValue->getName());
    }

    public function testOptionValueProxyReturnsOptionNamePresentation()
    {
        $this->optionValue->setOption($this->option);
        $this->assertEquals('PRESENTATION', $this->optionValue->getPresentation());
    }

    public function testOptionValueStringConversionValueIsRepresented()
    {
        $this->assertInternalType('string', (string) $this->optionValue);
        $this->assertEquals('', (string) $this->optionValue);
    }

    public function testOptionValueStringConversionYieldsValue()
    {
        $this->optionValue->setValue('VALUE');
        $this->assertEquals('VALUE', (string) $this->optionValue);
    }
}
