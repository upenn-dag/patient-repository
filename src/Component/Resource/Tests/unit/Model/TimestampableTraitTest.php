<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Resource\Model;

use DateTime;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Resource\Test\Stub\TimestampableResource;

/**
 * Timestampable trait tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TimestampableTraitTest extends Test
{
    public function _before()
    {
        $this->date = new DateTime();
        $this->timestampable = new TimestampableResource();
    }

    // Internal use only
    public function testTimestampableImplementsInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\TimestampableInterface',
            $this->timestampable
        );
    }

    public function testTimestampableCreateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'createdAt', $this->timestampable);
        $this->assertNull($this->timestampable->getCreatedAt());
    }

    public function testTimestampableCreateIsMutable()
    {
        $expected = $this->date;
        $this->timestampable->setCreatedAt($expected);
        $this->assertSame($expected, $this->timestampable->getCreatedAt());
    }

    public function testTimestampableCreateIsFluent()
    {
        $this->assertSame($this->timestampable, $this->timestampable->setCreatedAt($this->date));
    }

    public function testTimestampableUpdateIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'updatedAt', $this->timestampable);
        $this->assertNull($this->timestampable->getUpdatedAt());
    }

    public function testTimestampableUpdateIsMutable()
    {
        $expected = $this->date;
        $this->timestampable->setUpdatedAt($expected);
        $this->assertSame($expected, $this->timestampable->getUpdatedAt());
    }

    public function testTimestampableUpdateIsFluent()
    {
        $this->assertSame($this->timestampable, $this->timestampable->setUpdatedAt($this->date));
    }
}
