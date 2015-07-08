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

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Resource\Test\Stub\VersionableResource;

/**
 * Versionable trait tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class VersionableTraitTests extends Test
{
    public function _before()
    {
        $this->versionable = new VersionableResource();
    }

    // Internal use only.
    public function testVersionableImplementsInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\VersionableInterface',
            $this->versionable
        );
    }

    public function testVersionableVersionIsZeroOnCreation()
    {
        $this->assertAttributeSame(0, 'currentVersion', $this->versionable);
        $this->assertSame(0, $this->versionable->getCurrentVersion());
    }

    public function testVersionableVersionIsMutable()
    {
        $expected = 1;
        $this->versionable->setCurrentVersion($expected);
        $this->assertSame($expected, $this->versionable->getCurrentVersion());
    }

    public function testVersionableVersionIsFluent()
    {
        $this->assertSame($this->versionable, $this->versionable->setCurrentVersion(1));
    }
}
