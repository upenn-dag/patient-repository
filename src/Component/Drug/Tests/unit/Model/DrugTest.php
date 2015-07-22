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
use Accard\Component\Drug\Model\Drug;
use Accard\Component\Drug\Model\DrugGroup;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Drug tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DrugTest extends Test
{
    protected function _before()
    {
        $this->drug = new Drug();
        $this->brand = Mockery::mock('Accard\\Component\\Drug\\Model\\DrugInterface')
            ->shouldReceive('setGeneric')->zeroOrMoreTimes()->andReturn(Mockery::self())
            ->getMock();
        $this->generic = Mockery::mock('Accard\\Component\\Drug\\Model\\DrugInterface');
        $this->group = Mockery::mock('Accard\\Component\\Drug\\Model\\DrugGroupInterface');
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
            'DAG\Component\Resource\Model\ResourceInterface',
            $this->drug
        );
    }

    public function testDrugIdIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->drug);
        $this->assertNull($this->drug->getId());
    }

    public function testDrugNameIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'name', $this->drug);
        $this->assertNull($this->drug->getName());
    }

    public function testDrugNameIsMutable()
    {
        $expected = 'NAME';
        $this->drug->setName($expected);
        $this->assertAttributeSame($expected, 'name', $this->drug);
        $this->assertSame($expected, $this->drug->getName());
    }

    public function testDrugNameSettingIsFluent()
    {
        $this->assertSame($this->drug, $this->drug->setName('NAME'));
    }

    public function testDrugPresentationIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'presentation', $this->drug);
        $this->assertNull($this->drug->getPresentation());
    }

    public function testDrugPresentationIsMutable()
    {
        $expected = 'PRESENTATION';
        $this->drug->setPresentation($expected);
        $this->assertAttributeSame($expected, 'presentation', $this->drug);
        $this->assertSame($expected, $this->drug->getPresentation());
    }

    public function testDrugPresentationSettingIsFluent()
    {
        $this->assertSame($this->drug, $this->drug->setPresentation('PRESENTATION'));
    }

    public function testDrugGenericIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'generic', $this->drug);
        $this->assertNull($this->drug->getGeneric());
    }

    public function testDrugGenericIsMutable()
    {
        $expected = $this->generic;
        $this->drug->setGeneric($expected);
        $this->assertAttributeSame($expected, 'generic', $this->drug);
        $this->assertSame($expected, $this->drug->getGeneric());
    }

    public function testDrugIsGenericReturnsFalseWhenGenericPresent()
    {
        $this->drug->setGeneric($this->generic);
        $this->assertFalse($this->drug->isGeneric());
    }

    public function testDrugIsGenericReturnsTrueWhenGenericIsNotPresent()
    {
        $this->assertTrue($this->drug->isGeneric());
    }

    public function testDrugGroupsIsAnEmptyCollectionOnCreation()
    {
        $this->assertAttributeInstanceOf('Doctrine\\Common\\Collections\\Collection', 'groups', $this->drug);
        $this->assertAttributeEmpty('groups', $this->drug);
        $this->assertInstanceOf('Doctrine\\Common\\Collections\\Collection', $this->drug->getGroups());
        $this->assertEmpty($this->drug->getGroups());
    }

    public function testDrugGroupsCanAddDrugGroup()
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

    public function testDrugGroupAddIsFluent()
    {
        $this->assertSame($this->drug, $this->drug->addGroup($this->group));
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

    public function testDrugGroupRemoveIsFluent()
    {
        $this->assertSame($this->drug, $this->drug->removeGroup($this->group));
    }


    public function testDrugBrandsIsEmptyCollectionOnCreation()
    {
        $this->assertAttributeInstanceOf('Doctrine\\Common\\Collections\\Collection', 'brands', $this->drug);
        $this->assertAttributeEmpty('brands', $this->drug);
        $this->assertInstanceOf('Doctrine\\Common\\Collections\\Collection', $this->drug->getBrands());
        $this->assertEmpty($this->drug->getBrands());
    }

    public function testDrugBrandCanAddBrandDrug()
    {
        $this->drug->addBrand($this->brand);
        $this->assertCount(1, $this->drug->getBrands());
    }

    public function testDrugBrandDoesNotAddBrandDrugTwice()
    {
        $this->drug->addBrand($this->brand);
        $this->drug->addBrand($this->brand);
        $this->assertCount(1, $this->drug->getBrands());
    }

    public function testDrugBrandAddIsFluent()
    {
        $this->assertSame($this->drug, $this->drug->addBrand($this->brand));
    }

    public function testDrugDoesNotFindBrandDrugWhenNotPresent()
    {
        $this->assertFalse($this->drug->hasBrand($this->brand));
    }

    public function testDrugFindsBrandDrugWhenPresent()
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

    public function testDrugBrandRemoveIsFluent()
    {
        $this->assertSame($this->drug, $this->drug->removeBrand($this->brand));
    }

    public function testDrugToStringGeneric()
    {
        $expected = 'Drug #NAME (generic)';
        $this->drug->setName('NAME');
        $this->assertSame($expected, (string) $this->drug);
    }

    public function testDrugToStringBrand()
    {
        $expected = 'Drug #NAME (brand)';
        $this->drug->setName('NAME');
        $this->drug->setGeneric($this->generic);
        $this->assertSame($expected, (string) $this->drug);
    }
}