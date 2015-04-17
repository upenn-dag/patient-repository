<?php
namespace AccardTest\Component\Drug\Model;

/**
 * Drugable Prototype Trait Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
require __DIR__.'/../Stub/DrugablePrototype.php';

use Stub\DrugablePrototype;
use Accard\Component\Drug\Model\DrugGroup;
use Mockery;


class DrugablePrototypeTraitTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->prototype = new DrugablePrototype();
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

    /**
     * DrugablePrototype->allowDrug
     */
    public function testDrugablePrototypeDoesNotAllowDrugByDefault()
    {
        $this->assertSame(False, $this->prototype->getAllowDrug());
    }

    public function testDrugablePrototypeAllowDrugIsMutable()
    {
        $this->prototype->setAllowDrug(True);
        $this->assertSame(True, $this->prototype->getAllowDrug());
    }

    /**
     * DrugablePrototype->drugGroup
     */
    public function testDrugablePrototypeDrugGroupAcceptsDrugableInterface()
    {
        $this->group = Mockery::mock('Accard\Component\Drug\Model\DrugGroupInterface');

        $this->prototype->setDrugGroup($this->group);
        $this->assertSame($this->prototype->getDrugGroup(), $this->group);
    }

    public function testDrugablePrototypeDrugGroupAcceptsNull()
    {
        $this->group = null;

        $this->prototype->setDrugGroup($this->group);
        $this->assertSame($this->prototype->getDrugGroup(), $this->group);
    }
}