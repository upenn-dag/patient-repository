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
use Doctrine\Common\Collections\Collection;
use Accard\Component\Option\Model\Option;
use Accard\Component\Option\Model\OptionInterface;

/**
 * Option model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $this->optionValue->shouldReceive('setOption')->zeroOrMoreTimes()->andReturn($this->optionValue);

        $this->option = new Option();
    }

    public function testOptionInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Option\Model\OptionInterface',
            $this->option
        );
    }

    public function testOptionIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->option
        );
    }

    public function testOptionIdIsUnsetOnCreation()
    {
        $this->assertNull($this->option->getId());
    }

    public function testOptionValuesCollectionIsInitializedAndEmptyOnCreation()
    {
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Collections\Collection',
            'values',
            $this->option
        );
        $this->assertAttributeCount(0, 'values', $this->option);
        $this->assertCount(0, $this->option->getValues());
    }

    public function testOptionNameIsMutable()
    {
        $this->option->setName('NAME');
        $this->assertAttributeSame('NAME', 'name', $this->option);
        $this->assertSame('NAME', $this->option->getName());
    }

    public function testOptionPresentationIsMutable()
    {
        $this->option->setPresentation('PRESENTATION');
        $this->assertAttributeSame('PRESENTATION', 'presentation', $this->option);
        $this->assertSame('PRESENTATION', $this->option->getPresentation());
    }

    public function testOptionValuesCollectionCanBeSetOnItsOwn()
    {
        $collection = Mockery::mock('Doctrine\Common\Collections\Collection');
        $this->option->setValues($collection);
        $this->assertAttributeSame($collection, 'values', $this->option);
        $this->assertSame($collection, $this->option->getValues());
    }

    public function testOptionValueIsNotDetectedIfNotPresent()
    {
        $this->assertFalse($this->option->hasValue($this->optionValue));
    }

    public function testOptionValueMayBeAdded()
    {
        $this->option->addValue($this->optionValue);
        $this->assertAttributeCount(1, 'values', $this->option);
        $this->assertCount(1, $this->option->getValues());
    }

    public function testOptionValueParentSetWhenAdded()
    {
        // We can not reuse the previously set mock, we overwrite the setOption expectations.
        $optionValue = Mockery::mock('Accard\Component\Option\Model\OptionValueInterface');
        $optionValue
            ->shouldReceive('setOption')
            ->once()
            ->with($this->option)
            ->andReturn($optionValue);

        $this->option->addValue($optionValue);
    }

    public function testOptionValueCanBeFoundIfPresent()
    {
        $this->option->addValue($this->optionValue);
        $this->assertTrue($this->option->hasValue($this->optionValue));
    }

    public function testOptionValueIsNotAddedTwice()
    {
        $this->option->addValue($this->optionValue);
        $this->option->addValue($this->optionValue);
        $this->assertAttributeCount(1, 'values', $this->option);
    }

    public function testOptionValueMayBeRemoved()
    {
        $this->option->addValue($this->optionValue);
        $this->option->removeValue($this->optionValue);
        $this->assertAttributeCount(0, 'values', $this->option);
    }

    public function testOptionFluency()
    {
        $this->assertSame($this->option, $this->option->setName('NAME'));
        $this->assertSame($this->option, $this->option->setPresentation('PRESENTATION'));
        $this->assertSame($this->option, $this->option->addValue($this->optionValue));
        $this->assertSame($this->option, $this->option->removeValue($this->optionValue));
    }

    public function testOptionStringConversionValueIsRepresented()
    {
        $this->assertInternalType('string', (string) $this->option);
        $this->assertEquals('', (string) $this->option);
    }

    public function testOptionStringConversionYieldsName()
    {
        $this->option->setName('NAME');
        $this->assertEquals('NAME', (string) $this->option);
    }
}
