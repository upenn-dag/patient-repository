<?php
namespace AccardTest\Component\Drug\Model;

/**
 * Drug model tests
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Component\Drug\Model\Drug;
use Accard\Component\Drug\Model\DrugGroup;
use Doctrine\Common\Collections\ArrayCollection;

class DrugTest extends \Codeception\TestCase\Test
{
    /**
     * @var \AccardTest\Component\Drug\\UnitTester
     */
    protected $tester;


    protected function _before()
    {
        $this->drug = new Drug();
        $this->brand = new Drug();
        $this->generic = new Drug();
        $this->group = new DrugGroup();
    }

    protected function _after()
    {
    }

    public function testDrugInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Drug\Model\DrugInterface',
            $this->drug
        );
    }

    public function testDrugIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->drug
        );
    }

    /**
     * Drug->id
     */
    public function testDrugIdIsUnsetOnCreation()
    {
        $this->assertNull($this->drug->getId());
    }

    /**
     * Drug->name
     */
    public function testDrugNameIsMutable()
    {
        $this->drug->setName('NAME');
        $this->assertAttributeSame('NAME', 'name', $this->drug);
        $this->assertSame('NAME', $this->drug->getName());
    }

    /**
     * Drug->group
     */
    public function testDrugPresentationIsMutable()
    {
        $this->drug->setPresentation('PRESENTATION');
        $this->assertAttributeSame('PRESENTATION', 'presentation', $this->drug);
        $this->assertSame('PRESENTATION', $this->drug->getPresentation());
    }
    
    /**
     * Drug->generic
     */
    public function testDrugGenericAcceptsDrugInterface()
    {
        $this->drug->setGeneric($this->generic);
        $this->assertAttributeSame($this->generic, 'generic', $this->drug);
        $this->assertSame($this->generic, $this->drug->getGeneric());
    }

    public function testDrugIsGenericReturnsFalseWhenGenericPresent()
    {
        $this->drug->setGeneric($this->generic);
        $this->assertSame(False, $this->drug->isGeneric());
    }

    public function testDrugIsGenericReturnsTrueWhenGenericIsNotPresent()
    {
        $this->assertSame(True, $this->drug->isGeneric());
    }

    /**
     * Drug->groups
     */
    public function testDrugGroupsIsInstanceOfArrayCollectionByDefault()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->drug->getGroups());
    }

    public function testDrugGroupsCanAddDrugGroupInterface()
    {
        $this->drug->addGroup($this->group);
        $this->assertCount(1, $this->drug->getGroups());
    }

    public function testDrugGroupsDoesNotAddGroupTwice()
    {
        $this->drug->addGroup($this->group);
        $this->drug->addGroup($this->group);
        $this->assertCount(1, $this->drug->getGroups());
    }

    public function testDrugDoesNotFindGroupWhenNotPresent()
    {
        $this->assertFalse($this->drug->hasGroup($this->group));
    }

    public function testDrugFindsGroupWhenPresent()
    {
        $this->drug->addGroup($this->group);
        $this->assertTrue($this->drug->hasGroup($this->group));
    }

    public function testDrugCanRemoveGroup()
    {
        $this->drug->addGroup($this->group);
        $this->drug->removeGroup($this->group);
        $this->assertCount(0, $this->drug->getGroups());
    }

    /**
     * Drug->brand
     */
    public function testDrugBrandsIsInstanceOfArrayCollectionByDefault()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->drug->getBrands());
    }

    public function testDrugBrandCanAddDrugInterface()
    {
        $this->drug->addBrand($this->brand);
        $this->assertCount(1, $this->drug->getBrands());
    }

    public function testDrugBrandDoesNotAddBrandTwice()
    {
        $this->drug->addBrand($this->brand);
        $this->drug->addBrand($this->brand);
        $this->assertCount(1, $this->drug->getBrands());
    }

    public function testDrugDoesNotFindBrandWhenNotPresent()
    {
        $this->assertFalse($this->drug->hasBrand($this->brand));
    }

    public function testDrugFindsBrandWhenPresent()
    {
        $this->drug->addBrand($this->brand);
        $this->assertTrue($this->drug->hasBrand($this->brand));
    }

    public function testDrugCanRemoveBrand()
    {
        $this->drug->addBrand($this->brand);
        $this->drug->removeBrand($this->brand);
        $this->assertCount(0, $this->drug->getBrands());
    }

    public function testDrugConvertsToExpectedFormatWhenOnlyNameIsPresent()
    {
        $this->drug->setName('NAME');
        $this->assertSame('Drug #NAME (generic)', (string)$this->drug);
    }

    public function testDrugConvertsToExpectedFormatWhenNameAndGenericIsPresent()
    {
        $this->drug->setName('NAME');
        $this->drug->setGeneric($this->generic);

        $this->assertSame('Drug #NAME (brand)', (string)$this->drug);
    }


}