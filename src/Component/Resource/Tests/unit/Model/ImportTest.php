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

use DateInterval;
use Mockery;
use Codeception\TestCase\Test;
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Resource\Model\Import;

/**
 * Resource model tests
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Karl Zipser <kzipser@mail.med.upenn.edu>
 */
class ImportTest extends Test
{
    protected function _before()
    {
        $this->import = new Import();
    }

    public function testClassInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ImportInterface',
            $this->import
        );
    }

    public function testImportIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->import);
        $this->assertNull($this->import->getId());
    }

    public function testImportActiveIsTrueOnCreation()
    {
        $this->assertAttributeSame(true, 'active', $this->import);
        $this->assertTrue($this->import->isActive());
    }

    public function testImportActiveIsMutable()
    {
        $expected = false;
        $this->import->setActive($expected);
        $this->assertSame($expected, $this->import->isActive());
    }

    public function testImportStartTimestampIsSetOnCreation()
    {
        $this->assertAttributeInternalType('float', 'startTimestamp', $this->import);
        $this->assertInternalType('float', $this->import->getStartTimestamp());
    }

    public function testImportEndTimestampIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'endTimestamp', $this->import);
        $this->assertNull($this->import->getEndTimestamp());
    }

    public function testImportEndTimestampIsMutable()
    {
        $expected = microtime(true);
        $this->import->setEndTimestamp($expected);
        $this->assertSame($expected, $this->import->getEndTimestamp());
    }

    public function testImportEndTimestampGetsCurrentMicrotimeWhenSetWithoutArgs()
    {
        $this->import->setEndTimestamp();
        $this->assertInternalType('float', $this->import->getEndTimestamp());
    }

    public function testImportImporterIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'importer', $this->import);
        $this->assertNull($this->import->getImporter());
    }

    public function testImportImporterIsMutable()
    {
        $expected = 'IMPORTER';
        $this->import->setImporter($expected);
        $this->assertSame($expected, $this->import->getImporter());
    }

    public function testImportCriteriaIsBlankArrayOnCreation()
    {
        $this->assertAttributeSame(array(), 'criteria', $this->import);
        $this->assertSame(array(), $this->import->getCriteria());
    }

    public function testImportCriteriaIsMutable()
    {
        $expected = array('criteria');
        $this->import->setCriteria($expected);
        $this->assertSame($expected, $this->import->getCriteria());
    }


    // Derived data...

    public function testImportDurationCalculationDuringRuntime()
    {
        $result = $this->import->getDuration();
        $this->assertGreaterThan(0, $result);
        $this->assertInternalType('float', $result);
        $this->assertLessThan($this->import->getStartTimestamp(), $result);
    }

    public function testImportDurationCalculationExplicitlySet()
    {
        $end = $this->import->getStartTimestamp() + 0.1;
        $this->import->setEndTimestamp($end);

        $result = $this->import->getDuration();
        $this->assertGreaterThan(0, $result);
        $this->assertInternalType('float', $result);
        $this->assertLessThan($this->import->getStartTimestamp(), $result);
    }

    public function testImportDurationIntervalCreated()
    {
        $this->assertInstanceOf('DateInterval', $this->import->getDurationAsInterval());
    }
}
