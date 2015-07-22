<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Diagnosis\Model;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Diagnosis\Model\Code;

/**
 * Diagnosis code model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeTest extends Test
{
    protected function _before()
    {
      $this->code = new Code;
      $this->codeGroup = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\CodeGroupInterface');
    }

    public function testCodeInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Diagnosis\Model\CodeInterface',
            $this->code
        );
    }

    public function testCodeIsAccardResource()
    {
        $this->assertInstanceOf(
            'DAG\Component\Resource\Model\ResourceInterface',
            $this->code
        );
    }

    public function testCodeIdIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->code);
        $this->assertNull($this->code->getId());
    }

    public function testCodeCodeIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'code', $this->code);
        $this->assertNull($this->code->getCode());
    }

    public function testCodeCodeIsMutable()
    {
        $expected = 'CODE';
        $this->code->setCode($expected);
        $this->assertSame($expected, $this->code->getCode());
    }

    public function testCodeCodeSettingIsFluent()
    {
        $this->assertSame($this->code, $this->code->setCode('CODE'));
    }

    public function testCodeDescriptionIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'description', $this->code);
        $this->assertNull($this->code->getDescription());
    }

    public function testCodeDescriptionIsMutable()
    {
        $expected = 'DESCRIPTION';
        $this->code->setDescription($expected);
        $this->assertAttributeSame($expected, 'description', $this->code);
        $this->assertSame($expected, $this->code->getDescription());
    }

    public function testCodeDescriptionSettingIsFluent()
    {
        $this->assertSame($this->code, $this->code->setDescription('DESCRIPTION'));
    }

    public function testCodeGroupsAreEmptyCollectionOnCreation()
    {
        $this->assertAttributeInstanceOf('Doctrine\\Common\\Collections\\Collection', 'groups', $this->code);
        $this->assertAttributeEmpty('groups', $this->code);
        $this->assertInstanceOf('Doctrine\\Common\\Collections\\Collection', $this->code->getGroups());
        $this->assertEmpty($this->code->getGroups());
    }

    public function testCodeGroupsCanBeAdded()
    {
        $this->code->addGroup($this->codeGroup);
        $this->assertCount(1, $this->code->getGroups());
    }

    public function testCodeGroupsAreNotAddedTwice()
    {
        $this->code->addGroup($this->codeGroup);
        $this->code->addGroup($this->codeGroup);
        $this->assertCount(1, $this->code->getGroups());
    }

    public function testCodeGroupAddIsFluent()
    {
        $this->assertSame($this->code, $this->code->addGroup($this->codeGroup));
    }

    public function testCodeGroupsCanNotBeDetectedWhenNotPresent()
    {
        $this->assertFalse($this->code->hasGroup($this->codeGroup));
    }

    public function testCodeGroupsCanBeDetectedWhenPresent()
    {
        $this->code->addGroup($this->codeGroup);
        $this->assertTrue($this->code->hasGroup($this->codeGroup));
    }

    public function testCodeGroupsCanBeRemoved()
    {
        $this->code->addGroup($this->codeGroup);
        $this->code->removeGroup($this->codeGroup);
        $this->assertCount(0, $this->code->getGroups());
    }

    public function testCodeGroupsDoNotRemoveNonRequestedCodeGroups()
    {
        $group = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\CodeGroupInterface');
        $this->code->addGroup($this->codeGroup);
        $this->code->removeGroup($group);
        $this->assertCount(1, $this->code->getGroups());
    }

    public function testCodeGroupRemoveIsFluent()
    {
        $this->assertSame($this->code, $this->code->removeGroup($this->codeGroup));
    }

    public function testCodeGroupToStringOutput()
    {
        $expected = 'DiagnosisCode#0';
        $this->assertSame($expected, (string) $this->code);
    }
}
