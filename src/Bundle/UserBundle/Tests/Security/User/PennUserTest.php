<?php

namespace Accard\Bundle\UserBundle\Tests\Security\User;

use Accard\Bundle\UserBundle\Tests\UserTestCase;
use Accard\Bundle\UserBundle\Security\User\PennUser;

/**
 * Basic Penn-based user implementation test
 *
 * @author Michael Woods <micwoods@mail.med.upenn.edu>
 */
class PennUserTest extends UserTestCase
{
    public function testConstructorIsCorrect()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertAttributeEquals("Sample-User-Id", "userId", $user);
        $this->assertAttributeEquals("Sample-User-Name", "userName", $user);
        $this->assertAttributeEquals("Sample-Given-Name", "givenName", $user);
        $this->assertAttributeEquals("Sample-Surname", "surName", $user);
        $this->assertAttributeEquals("Sample-Title", "title", $user);
        $this->assertAttributeEquals("Sample-Mail", "mail", $user);
        $this->assertAttributeEquals("Sample-Telephone-Number", "telephoneNumber", $user);
        $this->assertAttributeEquals(["Sample-Role-1", "Sample-Role-2"], "roles", $user);
    }

    public function testUserIdGetter()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertEquals("Sample-User-Id", $user->getUserId());
    }

    public function testUserNameGetter()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertEquals("Sample-User-Name", $user->getUserName());
    }

    public function testGivenNameGetter()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertEquals("Sample-Given-Name", $user->getGivenName());
    }

    public function testSurnameGetter()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertEquals("Sample-Surname", $user->getSurname());
    }

    public function testTitleGetter()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertEquals("Sample-Title", $user->getTitle());
    }

    public function testMailGetter()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertEquals("Sample-Mail", $user->getMail());
    }

    public function testTelephoneNumberGetter()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertEquals("Sample-Telephone-Number", $user->getTelephoneNumber());
    }

    public function testRolesGetter()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertEquals(["Sample-Role-1", "Sample-Role-2"], $user->getRoles());
    }

    public function testAssertPasswordIsUnusedAndNull()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertNull($user->getPassword());
    }

    public function testAssertSaltIsUnusedAndNull()
    {
        $user = new PennUser("Sample-User-Id",
                             "Sample-User-Name",
                             "Sample-Given-Name",
                             "Sample-Surname",
                             "Sample-Title",
                             "Sample-Mail",
                             "Sample-Telephone-Number",
                             ["Sample-Role-1", "Sample-Role-2"]);
        $this->assertNull($user->getSalt());
    }
}