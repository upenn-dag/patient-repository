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
use Accard\Component\Diagnosis\Model\CodeGroup;

/**
 * Diagnosis code model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeGroupTest extends Test
{
    protected function _before()
    {
        $this->code = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\CodeInterface')
        ->shouldReceive('addGroup')->zeroOrMoreTimes()->andReturn(Mockery::self())
        ->shouldReceive('removeGroup')->zeroOrMoreTimes()->andReturn(Mockery::self())
        ->getMock();

        $this->codeGroup = new CodeGroup();
    }

    public function testCodeGroupInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Diagnosis\Model\CodeGroupInterface',
            $this->codeGroup
        );
    }

    public function testCodeGroupIsAccardResource()
    {
        $this->assertInstanceOf(
            'DAG\Component\Resource\Model\ResourceInterface',
            $this->codeGroup
        );
    }

    public function testCodeGroupIdIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->codeGroup);
        $this->assertNull($this->codeGroup->getId());
    }

    public function testCodeGroupNameIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'name', $this->codeGroup);
        $this->assertNull($this->codeGroup->getName());
    }

    public function testCodeGroupNameIsMutable()
    {
        $expected = 'NAME';
        $this->codeGroup->setName($expected);
        $this->assertSame($expected, $this->codeGroup->getName());
    }

    public function testCodeGroupNameSettingIsFluent()
    {
        $this->assertSame($this->codeGroup, $this->codeGroup->setName('NAME'));
    }

    public function testCodeGroupPresentationIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'presentation', $this->codeGroup);
        $this->assertNull($this->codeGroup->getPresentation());
    }

    public function testCodeGroupPresentationIsMutable()
    {
        $expected = 'PRESENTATION';
        $this->codeGroup->setPresentation($expected);
        $this->assertAttributeSame($expected, 'presentation', $this->codeGroup);
        $this->assertSame($expected, $this->codeGroup->getPresentation());
    }

    public function testCodeGroupPresentationSettingIsFluent()
    {
        $this->assertSame($this->codeGroup, $this->codeGroup->setPresentation('PRESENTATION'));
    }


    public function testCodeGroupCodesAreEmptyCollectionOnCreation()
    {
        $this->assertAttributeInstanceOf('Doctrine\\Common\\Collections\\Collection', 'codes', $this->codeGroup);
        $this->assertAttributeEmpty('codes', $this->codeGroup);
        $this->assertInstanceOf('Doctrine\\Common\\Collections\\Collection', $this->codeGroup->getCodes());
        $this->assertEmpty($this->codeGroup->getCodes());
    }

    public function testCodeGroupCodesCanBeAdded()
    {
        $this->codeGroup->addCode($this->code);
        $this->assertCount(1, $this->codeGroup->getCodes());
    }

    public function testCodeGroupCodesAreNotAddedTwice()
    {
        $this->codeGroup->addCode($this->code);
        $this->codeGroup->addCode($this->code);
        $this->assertCount(1, $this->codeGroup->getCodes());
    }

    public function testCodeGroupCodeAddIsFluent()
    {
        $this->assertSame($this->codeGroup, $this->codeGroup->addCode($this->code));
    }

    public function testCodeGroupCodesCanNotBeDetectedWhenNotPresent()
    {
        $this->assertFalse($this->codeGroup->hasCode($this->code));
    }

    public function testCodeGroupCodesCanBeDetectedWhenPresent()
    {
        $this->codeGroup->addCode($this->code);
        $this->assertTrue($this->codeGroup->hasCode($this->code));
    }

    public function testCodeGroupCodesCanBeRemoved()
    {
        $this->codeGroup->addCode($this->code);
        $this->codeGroup->removeCode($this->code);
        $this->assertCount(0, $this->codeGroup->getCodes());
    }

    public function testCodeGroupCodesDoNotRemoveNonRequestedCodeGroups()
    {
        $code = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\CodeInterface');
        $this->codeGroup->addCode($this->code);
        $this->codeGroup->removeCode($code);
        $this->assertCount(1, $this->codeGroup->getCodes());
    }

    public function testCodeGroupCodeRemoveIsFluent()
    {
        $this->assertSame($this->codeGroup, $this->codeGroup->removeCode($this->code));
    }
}
