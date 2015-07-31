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
use Accard\Component\Drug\Test\Stub\DrugablePrototype;

/**
 * Drugable prototype trait tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DrugablePrototypeTraitTest extends Test
{
    protected function _before()
    {
        $this->prototype = new DrugablePrototype();
        $this->drugGroup = Mockery::mock('Accard\Component\Drug\Model\DrugGroupInterface');
    }
    /**
     * Interface tests
     */
    public function testDrugablePrototypeInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Drug\Model\DrugablePrototypeInterface',
            $this->prototype
        );
    }

    public function testDrugablePrototypeDoesNotAllowDrugByDefault()
    {
        $this->assertAttributeSame(false, 'allowDrug', $this->prototype);
        $this->assertFalse($this->prototype->getAllowDrug());
    }

    public function testDrugablePrototypeAllowDrugIsMutable()
    {
        $this->prototype->setAllowDrug(true);
        $this->assertTrue($this->prototype->getAllowDrug());
    }

    public function testDrugablePrototypeAllowDrugSettingIsFluent()
    {
        $this->assertSame($this->prototype, $this->prototype->setAllowDrug(false));
    }

    public function testDrugablePrototypeDrugGroupIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'drugGroup', $this->prototype);
        $this->assertNull($this->prototype->getDrugGroup());
    }

    public function testDrugablePrototypeDrugGroupIsMutable()
    {
        $this->prototype->setDrugGroup($this->drugGroup);
        $this->assertSame($this->prototype->getDrugGroup(), $this->drugGroup);
    }

    public function testDrugablePrototypeDrugGroupIsNullable()
    {
        $this->prototype->setDrugGroup(null);
        $this->assertNull($this->prototype->getDrugGroup());
    }

    public function testDrugablePrototypeDrugGroupSettingIsFluent()
    {
        $this->assertSame($this->prototype, $this->prototype->setDrugGroup($this->drugGroup));
    }
}
