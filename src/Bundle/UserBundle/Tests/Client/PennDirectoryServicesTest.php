<?php

namespace Accard\Bundle\UserBundle\Tests\Client;

use Accard\Bundle\UserBundle\Tests\UserTestCase;

/**
 * Penn user directory services manager test cases
 *
 * @author Michael Woods <micwoods@mail.med.upenn.edu>
 */
class PennDirectoryServicesTest extends UserTestCase
{
  public function testConstructorInitialized()
  {
    $cache       = new \DAG\Penn\Directory\Cache\DummyCache();
    $dirServices = new \DAG\Penn\Directory\Personnel\Client($cache);

    $this->assertAttributeEquals($cache, "cache", $dirServices);
  }

  public function testFindByPennKeyWithWorkingPennKey()
  {
    $stub = $this->getMock('\DAG\Penn\Directory\Personnel\Client');
    $expected = [
      "uid"             => [0 => 'jsmith'],
      "givenName"       => [0 => 'Smith, John'],
      "sn"              => [0 => 'SMITH'],
      "title"           => [0 => 'Professional dude'],
      "mail"            => [0 => 'john.smith@mail.med.upenn.edu'],
      "telephoneNumber" => [0 => '+215 555-5555']
    ];
    $stub->expects($this->any())
         ->method('findByPennKey')
         ->will($this->returnValue($expected));
    $actual = $stub->findByPennKey("jsmith");
    $this->assertArrayHasKey("mail", $actual);
    $this->assertArrayHasKey(0, $actual['mail']);
    $this->assertEquals('john.smith@mail.med.upenn.edu', $actual['mail'][0]);
  }

  public function testFindByPennKeyWithBadPennKey()
  {
    $stub = $this->getMock('\DAG\Penn\Directory\Personnel\Client');
    $stub->expects($this->any())
         ->method('findByPennKey')
         ->will($this->returnValue([]));
    $actual = $stub->findByPennKey("bad");
    $this->assertEquals([], $actual);
  }
}
