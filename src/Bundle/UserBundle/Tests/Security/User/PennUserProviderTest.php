<?php

namespace Accard\Bundle\UserBundle\Tests\Security\User;

require 'vendor/autoload.php';

use Accard\Bundle\UserBundle\Client\PennDirectoryServices;
use Accard\Bundle\UserBundle\Client\PennGroupsServices;
use Accard\Bundle\UserBundle\Client\PennGroupsWSClient;
use Accard\Bundle\UserBundle\Tests\UserTestCase;
use Accard\Bundle\UserBundle\Security\User\PennUser;
use Accard\Bundle\UserBundle\Security\User\PennUserProvider;

/**
 * Basic Penn-based user provider implementation test
 *
 * @author Michael Woods <micwoods@mail.med.upenn.edu>
 */
class PennUserProviderTest extends UserTestCase
{
  public function testNothing()
  {

  }
  
  // public function testConstructorInitialized()
  // {
  //   $ldapClient = $this->getMockBuilder('Accard\Bundle\UserBundle\Client\LDAPClient')
  //                      ->disableOriginalConstructor()
  //                      ->getMock();
  //   $wsClient = $this->getMockBuilder('Accard\Bundle\UserBundle\Client\PennGroupsWSClient')
  //                    ->disableOriginalConstructor()
  //                    ->getMock();
  //   $groupsServices = new PennGroupsServices($ldapClient, $wsClient);
  //   $this->assertAttributeEquals($ldapClient, "ldapClient", $groupsServices);
  //   $this->assertAttributeEquals($wsClient, "wsClient", $groupsServices);
  // }

  // public function testLoadUserByUsernameWithWorkingPennKey()
  // {
  //   $dirServicesLdapClient = $this->getMock('Accard\Bundle\UserBundle\Client\LDAPClient'
  //                                          ,['search']
  //                                          ,[]
  //                                          ,"LDAPClient"
  //                                          ,false);
  //   $expected1 = [
  //     "uid"             => [0 => 'jsmith'],
  //     "givenName"       => [0 => 'Smith, John'],
  //     "sn"              => [0 => 'SMITH'],
  //     "title"           => [0 => 'Professional dude'],
  //     "mail"            => [0 => 'john.smith@mail.med.upenn.edu'],
  //     "telephoneNumber" => [0 => '+215 555-5555']
  //   ];
  //   $dirServicesLdapClient->expects($this->any())
  //        ->method('search')
  //        ->will($this->returnValue($expected1));

  //   $dirServices = new PennDirectoryServices($dirServicesLdapClient, "Sample-DN");

  //   $groupsLdapClient = $this->getMock('Accard\Bundle\UserBundle\Client\LDAPClient'
  //                               ,['search']
  //                               ,[]
  //                               ,"LDAPClient"
  //                               ,false);
  //   $expected2 = ["pennid" => ["123456789"]];
  //   $groupsLdapClient->expects($this->any())
  //        ->method('search')
  //        ->will($this->returnValue($expected2));
  //   $groupsWsClient = $this->getMock('Accard\Bundle\UserBundle\Client\PennGroupsWSClient'
  //                                   ,['getGroups']
  //                                   ,[]
  //                                   ,"PennGroupsWSClient"
  //                                   ,false);
  //   $expected3 = ["ROLE_VIEW", "ROLE_UPDATE"];
  //   $groupsWsClient->expects($this->any())
  //        ->method('getGroups')
  //        ->will($this->returnValue($expected3));
  //   $groupsServices = new PennGroupsServices($groupsLdapClient, $groupsWsClient);

  //   $userProvider = new PennUserProvider($dirServices, $groupsServices);

  //   $actual = $userProvider->loadUserByUsername("jsmith");

  //   $this->assertAttributeEquals("123456789", "userId", $actual);
  //   $this->assertAttributeEquals("jsmith", "userName", $actual);
  //   $this->assertAttributeEquals("Smith, John", "givenName", $actual);
  //   $this->assertAttributeEquals("SMITH", "surName", $actual);
  //   $this->assertAttributeEquals("Professional dude", "title", $actual);
  //   $this->assertAttributeEquals("john.smith@mail.med.upenn.edu", "mail", $actual);
  //   $this->assertAttributeEquals("+215 555-5555", "telephoneNumber", $actual);
  //   $this->assertAttributeEquals(["ROLE_VIEW", "ROLE_UPDATE"], "roles", $actual);
  // }
}