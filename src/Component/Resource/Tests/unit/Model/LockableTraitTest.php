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
use Accard\Component\Resource\Test\Stub\LockableResource;

/**
 * Lockable trait tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class LockableTraitTest extends Test
{
    public function _before()
    {
        $this->lockable = new LockableResource();
    }

    // Internal use only
    public function testLockableImplementsInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\LockableInterface',
            $this->lockable
        );
    }

    public function testLockableIsNotLockedOnCreation()
    {
        $this->assertAttributeSame(false, 'locked', $this->lockable);
        $this->assertFalse($this->lockable->isLocked());
    }

    public function testLockableLockIsMutable()
    {
        $expected = true;
        $this->lockable->setLocked($expected);
        $this->assertSame($expected, $this->lockable->isLocked());
    }

    public function testLockableLockIsFluent()
    {
        $this->assertSame($this->lockable, $this->lockable->setLocked(true));
    }

    public function testLockableLockShortcutBehavesProperly()
    {
        $this->lockable->lock();
        $this->assertTrue($this->lockable->isLocked());
    }

    public function testLockableLockShortcutIsFluent()
    {
        $this->assertSame($this->lockable, $this->lockable->lock());
    }

    public function testLockableUnlockShortcutBehavesProperly()
    {
        $this->lockable->unlock();
        $this->assertFalse($this->lockable->isLocked());
    }

    public function testLockableUnlockShortcutIsFluent()
    {
        $this->assertSame($this->lockable, $this->lockable->unlock());
    }
}
