<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Sample\Model;

use DateTime;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Sample\Model\Source;

/**
 * Source model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SourceTest extends Test
{
    protected function _before()
    {
        $this->sourceDate = new DateTime('2010-1-1 00:00:00');
        $this->source = new Source();

        $this->sample = Mockery::mock('Accard\Component\Sample\Model\SampleInterface')
            ->shouldReceive('setSource')->zeroOrMoreTimes()->andReturn(Mockery::self())
            ->getMock();
    }

    public function testSourceInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Sample\Model\SourceInterface',
            $this->source
        );
    }

    public function testSourceIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->source
        );
    }

    public function testSourceIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->source);
        $this->assertNull($this->source->getId());
    }

    public function testSourceSampleIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'sample', $this->source);
        $this->assertNull($this->source->getSample());
    }

    public function testSourceSampleIsMutable()
    {
        $expected = $this->sample;
        $this->source->setSample($expected);
        $this->assertSame($expected, $this->source->getSample());
    }

    public function testSourceSampleIsFluent()
    {
        $this->assertSame($this->source, $this->source->setSample($this->sample));
    }

    public function testSourceSampleIsNullable()
    {
        $this->source->setSample(null);
        $this->assertNull($this->source->getSample());
    }

    public function testSourceAmountIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'amount', $this->source);
        $this->assertNull($this->source->getAmount());
    }

    public function testSourceReportsAsDerivativeWhenParentSampleFound()
    {
        $this->source->setSample($this->sample);
        $this->assertTrue($this->source->isDerivation());
    }

    public function testSourceDoesNotReportAsDerivativeWithoutParentSample()
    {
        $this->assertFalse($this->source->isDerivation());
    }

    public function testSourceAmountIsNullable()
    {
        $this->source->setSample(null);
        $this->assertNull($this->source->getAmount());
    }

    public function testSourceAmountIsMutable()
    {
        $expected = 1;
        $this->source->setAmount($expected);
        $this->assertSame($expected, $this->source->getAmount());
    }

    public function testSourceDateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'sourceDate', $this->source);
        $this->assertNull($this->source->getSourceDate());
    }

    public function testSourceDateIsMutable()
    {
        $expected = $this->sourceDate;
        $this->source->setSourceDate($expected);
        $this->assertSame($expected, $this->source->getSourceDate());
    }

    public function testSourceSamplesAreEmptyCollectionOnCreation()
    {
        $this->assertAttributeInstanceOf('Doctrine\Common\Collections\Collection', 'samples', $this->source);
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $this->source->getSamples());
        $this->assertCount(0, $this->source->getSamples());
    }

    public function testSourceSampleCanBeAdded()
    {
        $expected = $this->sample;
        $this->source->addSample($expected);
        $this->assertCount(1, $this->source->getSamples());
        $this->assertContains($expected, $this->source->getSamples());
    }

    public function testSourceSampleAddingIsFluent()
    {
        $this->assertSame($this->source, $this->source->addSample($this->sample));
    }

    public function testSourceSampleCanBeDetectedWhenAdded()
    {
        $this->source->addSample($this->sample);
        $this->assertTrue($this->source->hasSample($this->sample));
    }

    public function testSourceSampleCanNotBeDetectedWhenNotAdded()
    {
        $this->assertFalse($this->source->hasSample($this->sample));
    }

    public function testSourceSamplesCanBeRemoved()
    {
        $expected = $this->sample;
        $this->source->addSample($expected);
        $this->source->removeSample($expected);
        $this->assertCount(0, $this->source->getSamples());
        $this->assertNotContains($expected, $this->source->getSamples());
    }

    public function testSourceSampleRemovalIsFluent()
    {
        $this->assertSame($this->source, $this->source->removeSample($this->sample));
    }
}
