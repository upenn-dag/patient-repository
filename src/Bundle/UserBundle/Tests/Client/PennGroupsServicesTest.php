<?php

namespace Accard\Bundle\UserBundle\Tests\Client;

use Accard\Bundle\UserBundle\Tests\UserTestCase;
use Accard\Bundle\UserBundle\Client\PennGroupsServices;
use Accard\Bundle\UserBundle\Client\PennGroupsWSClient;

/**
 * PennGroups services manager tests
 *
 * @author Michael Woods <micwoods@mail.med.upenn.edu>
 */
class PennGroupsServicesTests extends UserTestCase
{
  public function testConstructorInitialized()
  {
    $ldapClient = $this->getMockBuilder('\DAG\Penn\Groups\LDAP\Client')
                       ->disableOriginalConstructor()
                       ->getMock();
    $wsClient = $this->getMockBuilder('\DAG\Penn\Groups\WS\Client')
                     ->disableOriginalConstructor()
                     ->getMock();
    $groupsServices = new \DAG\Penn\Groups\Client($ldapClient, $wsClient);
    $this->assertAttributeEquals($ldapClient, "ldapClient", $groupsServices);
    $this->assertAttributeEquals($wsClient, "wsClient", $groupsServices);
  }

  public function testTranslatePennKeyToIDForWorkingPennKey()
  {
    $ldapClient = $this->getMock('\DAG\Penn\Groups\LDAP\Client'
                                ,['pennKeyToID']
                                ,[]
                                ,"Client"
                                ,false);
    $ldapClient->expects($this->any())
               ->method('pennKeyToID')
               ->will($this->returnValue("123456789"));

    $wsClient = $this->getMockBuilder('\DAG\Penn\Groups\WS\Client')
                     ->disableOriginalConstructor()
                     ->getMock();

    $groupsServices = new \DAG\Penn\Groups\Client($ldapClient, $wsClient);
    $actual = $groupsServices->pennKeyToID("Good-Penn-Key");
    $this->assertEquals("123456789", $actual);
  }

  public function testTranslatePennKeyToIDForBadPennKey()
  {
    $ldapClient = $this->getMock('\DAG\Penn\Groups\LDAP\Client'
                                ,['pennKeyToID']
                                ,[]
                                ,"Client"
                                ,false);
    $expected = null;
    $ldapClient->expects($this->any())
               ->method('pennKeyToID')
               ->will($this->returnValue($expected));

    $wsClient = $this->getMockBuilder('\DAG\Penn\Groups\WS\Client')
                     ->disableOriginalConstructor()
                     ->getMock();
 
    $groupsServices = new \DAG\Penn\Groups\Client($ldapClient, $wsClient);
    $actual = $groupsServices->pennKeyToID("Bad-Penn-Key");
    $this->assertEquals(null, $actual);
  }

  public function testGetGroupsWithWorkingPennID()
  {
    $expected = ["ROLE_VIEW", "ROLE_UPDATE"];

    $ldapClient = $this->getMockBuilder('\DAG\Penn\Groups\LDAP\Client')
                       ->disableOriginalConstructor()
                       ->getMock();

    $wsClient = $this->getMockBuilder('\DAG\Penn\Groups\WS\Client')
                     ->disableOriginalConstructor()
                     ->setMethods(['getGroups'])
                     ->getMock();
    $wsClient->expects($this->any())
             ->method('getGroups')
             ->will($this->returnValue($expected));

    $groupsServices = new \DAG\Penn\Groups\Client($ldapClient, $wsClient);

    $this->assertEquals($expected, $groupsServices->getGroups('11111111', 'id'));
  }

  public function testGetGroupsWithWorkingBadPennKey()
  {
    $expected = ["ROLE_VIEW", "ROLE_UPDATE"];

    $ldapClient = $this->getMockBuilder('\DAG\Penn\Groups\LDAP\Client')
                       ->disableOriginalConstructor()
                       ->getMock();

    $wsClient = $this->getMockBuilder('\DAG\Penn\Groups\WS\Client')
                     ->disableOriginalConstructor()
                     ->setMethods(['getGroups'])
                     ->getMock();
    $wsClient->expects($this->any())
             ->method('getGroups')
             ->will($this->returnValue($expected));

    $groupsServices = new \DAG\Penn\Groups\Client($ldapClient, $wsClient);

    $this->assertEquals(false, $groupsServices->getGroups('BAD', 'key'));
  }
}
