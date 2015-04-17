<?php
namespace AccardTest\Component\Drug\Model;

/**
 * Drug Group Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Component\Drug\Model\DrugGroup;
use Accard\Component\Drug\Model\Drug;

class DrugGroupTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->group = new DrugGroup();
        $this->drug = new Drug();
    }

    protected function _after()
    {
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

    public function testDrugIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->group
        );
    }

    /**
     * DrugGroup->id
     */
    public function testGroupIdIsUnsetOnCreation()
    {
        $this->assertNull($this->group->getId());
    }

    /**
     * DrugGroup->name
     */

    public function testDrugGroupNameIsMutable()
    {
        $this->group->setName('NAME');
        $this->assertAttributeSame('NAME', 'name', $this->group);
        $this->assertSame('NAME', $this->group->getName());
    }

    /**
     * DrugGroup->presentation
     */
    public function testDrugGroupPresentationIsMutable()
    {
        $this->group->setPresentation('PRESENTATION');
        $this->assertAttributeSame('PRESENTATION', 'presentation', $this->group);
        $this->assertSame('PRESENTATION', $this->group->getPresentation());
    }

    /**
     * DrugGroup->drugs
     */
    public function testDrugGroupDrugsIsInstanceOfArrayCollectionByDefault()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->group->getDrugs());
    }

    public function testDrugGroupDrugsCanAddDrugInterface()
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

    public function testDrugGroupDoesNotFindDrugWhenNotPresent()
    {
        $this->assertFalse($this->group->hasDrug($this->drug));
    }

    public function testDrugGroupFindsDrugWhenPresent()
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

}