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
use Accard\Component\Resource\Test\Stub\UserResource;

/**
 * User tests.
 *
 * This is currently just a shell of a user object, we're testing for
 * basically coverage purposes only.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class UserTest extends Test
{
    public function _before()
    {
        $this->user = new UserResource();
    }

    // Internal use only
    public function testUserImplementsInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\UserInterface',
            $this->user
        );
    }

    public function testUserAccountNotExpired()
    {
        $this->assertTrue($this->user->isAccountNonExpired());
    }

    public function testUserAccountNotLocked()
    {
        $this->assertTrue($this->user->isAccountNonLocked());
    }

    public function testUserCredentialsNotLocked()
    {
        $this->assertTrue($this->user->isCredentialsNonExpired());
    }

    public function testUserEnabledIsNullOnCreation()
    {
        $this->assertNull($this->user->isEnabled());
    }

    public function testUserEnabledIsMutable()
    {
        $expected = true;
        $this->user->setEnabled($expected);
        $this->assertSame($expected, $this->user->isEnabled());
    }
}
