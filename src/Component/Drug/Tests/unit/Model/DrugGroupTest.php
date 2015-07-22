<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Drug\Model;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Drug\Model\DrugGroup;

/**
 * Drug group tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DrugGroupTest extends Test
{
    protected function _before()
    {
        $this->group = new DrugGroup();
        $this->drug = Mockery::mock('Accard\\Component\\Drug\\Model\\DrugInterface')
            ->shouldReceive('addGroup')->zeroOrMoretimes()->andReturn(Mockery::self())
            ->shouldReceive('removeGroup')->zeroOrMoretimes()->andReturn(Mockery::self())
            ->getMock();
    }

    /**
     * Interface tests
     */
    public function testDrugGroupInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Drug\Model\DrugGroupInterface',
            $this->group
        );
    }

    public function testDrugGroupIsAccardResource()
    {
        $this->assertInstanceOf(
            'DAG\Component\Resource\Model\ResourceInterface',
            $this->group
        );
    }

    public function testDrugGroupIdIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->group);
        $this->assertNull($this->group->getId());
    }

    public function testDrugGroupNameIsMutable()
    {
        $expected = 'NAME';
        $this->group->setName($expected);
        $this->assertAttributeSame($expected, 'name', $this->group);
        $this->assertSame($expected, $this->group->getName());
    }

    public function testDrugGroupPresentationIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'presentation', $this->group);
        $this->assertNull($this->group->getPresentation());
    }

    public function testDrugGroupPresentationIsMutable()
    {
        $expected = 'PRESENTATION';
        $this->group->setPresentation($expected);
        $this->assertAttributeSame($expected, 'presentation', $this->group);
        $this->assertSame($expected, $this->group->getPresentation());
    }


    public function testDrugGroupDrugsIsEmptyCollectionOnCreation()
    {
        $this->assertAttributeInstanceOf('Doctrine\\Common\\Collections\\Collection', 'drugs', $this->group);
        $this->assertAttributeEmpty('drugs', $this->group);
        $this->assertInstanceOf('Doctrine\\Common\\Collections\\Collection', $this->group->getDrugs());
        $this->assertEmpty($this->group->getDrugs());
    }

    public function testDrugGroupDrugsCanAddDrug()
    {
        $this->group->addDrug($this->drug);
        $this->assertCount(1, $this->group->getDrugs());
    }

    public function testDrugGroupDrugsDoesNotAddDrugTwice()
    {
        $this->group->addDrug($this->drug);
        $this->group->addDrug($this->drug);
        $this->assertCount(1, $this->group->getDrugs());
    }

    public function testDrugGroupAddIsFluent()
    {
        $this->assertSame($this->group, $this->group->addDrug($this->drug));
    }

    public function testDrugGroupCanNotDetectDrugWhenNotPresent()
    {
        $this->assertFalse($this->group->hasDrug($this->drug));
    }

    public function testDrugGroupCanDetectDrugWhenPresent()
    {
        $this->group->addDrug($this->drug);
        $this->assertTrue($this->group->hasDrug($this->drug));
    }

    public function testDrugGroupCanRemoveDrug()
    {
        $this->group->addDrug($this->drug);
        $this->group->removeDrug($this->drug);
        $this->assertCount(0, $this->group->getDrugs());
    }

    public function testDrugGroupDoesNotRemoveNonRequestedDrug()
    {
        $drug = Mockery::mock('Accard\\Component\\Drug\\Model\\DrugInterface');
        $this->group->addDrug($this->drug);
        $this->group->removeDrug($drug);
        $this->assertCount(1, $this->group->getDrugs());
    }
}