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
use Accard\Component\Sample\Model\Sample;
use Accard\Component\Field\Test\FieldSubjectTest;

/**
 * Sample model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SampleTest extends Test
{
    use FieldSubjectTest;

    protected function _before()
    {
        //$this->sampleDate = new DateTime('2010-1-1 00:00:00');
        $this->prototype = Mockery::mock('Accard\Component\Sample\Model\PrototypeInterface');
        $this->source = Mockery::mock('Accard\Component\Sample\Model\SourceInterface');
        $this->derivative = Mockery::mock('Accard\Component\Sample\Model\SourceInterface');
        $this->sample = new Sample();

        // Required by field subject test trait above.
        $this->fieldSubject = $this->sample;
    }

    public function testSampleInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Sample\Model\SampleInterface',
            $this->sample
        );
    }

    public function testSampleIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->sample
        );
    }

    public function testSampleIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->sample);
        $this->assertNull($this->sample->getId());
    }

    public function testSampleSourceIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'source', $this->sample);
        $this->assertNull($this->sample->getSource());
    }

    public function testSampleSourceIsMutable()
    {
        $expected = $this->source;
        $this->sample->setSource($expected);
        $this->assertSame($expected, $this->sample->getSource());
    }

    public function testSampleSourceIsFluent()
    {
        $this->assertSame($this->sample, $this->sample->setSource($this->source));
    }

    public function testSampleSourceIsNullable()
    {
        $this->sample->setSource(null);
        $this->assertNull($this->sample->getSource());
    }

    public function testSampleAmountIsZeroOnCreation()
    {
        $this->assertAttributeSame(0, 'amount', $this->sample);
        $this->assertSame(0, $this->sample->getAmount());
    }

    public function testSampleAmountIsMutable()
    {
        $expected = 1;
        $this->sample->setAmount($expected);
        $this->assertSame($expected, $this->sample->getAmount());
    }

    public function testSampleDerivativesAreEmptyCollectionOnCreation()
    {
        $this->assertAttributeInstanceOf('Doctrine\Common\Collections\Collection', 'derivatives', $this->sample);
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $this->sample->getDerivatives());
        $this->assertCount(0, $this->sample->getDerivatives());
    }

    public function testSampleDerviativeCanBeAdded()
    {
        $expected = $this->derivative;
        $this->sample->addDerivative($expected);
        $this->assertCount(1, $this->sample->getDerivatives());
        $this->assertContains($expected, $this->sample->getDerivatives());
    }

    public function testSampleDerviativeAddingIsFluent()
    {
        $this->assertSame($this->sample, $this->sample->addDerivative($this->derivative));
    }

    public function testSampleDerivativeCanBeDetectedWhenAdded()
    {
        $this->sample->addDerivative($this->derivative);
        $this->assertTrue($this->sample->hasDerivative($this->derivative));
    }

    public function testDerivativeCanNotBeDetectedWhenNotAdded()
    {
        $this->assertFalse($this->sample->hasDerivative($this->derivative));
    }

    public function testDerivativesCanReportTrueWhenPresent()
    {
        $this->sample->addDerivative($this->derivative);
        $this->assertTrue($this->sample->hasDerivatives());
    }

    public function testDerivativesDoNotReportTrueWhenNoDerivativesArePresent()
    {
        $this->assertFalse($this->sample->hasDerivatives());
    }

    public function testSampleDerivativeCanBeRemoved()
    {
        $expected = $this->derivative;
        $this->sample->addDerivative($expected);
        $this->sample->removeDerivative($expected);
        $this->assertCount(0, $this->sample->getDerivatives());
        $this->assertNotContains($expected, $this->sample->getDerivatives());
    }

    public function testDerivativeRemovalIsFluent()
    {
        $this->assertSame($this->sample, $this->sample->removeDerivative($this->derivative));
    }
}
