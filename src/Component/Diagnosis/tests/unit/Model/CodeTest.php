<?php
namespace Model;
use Accard\Component\Diagnosis\Model\Code;
use Mockery;

class CodeTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
      $this->code = new Code;
    }

    protected function _after()
    {
    }

    /**
     * Interface tests
     */
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
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->code
        );
    }

    /**
     * Code->id
     */
    public function testCodeIdIsUnsetOnCreation()
    {
        $this->assertNull($this->code->getId());
    }

    /**
     * Code->description
     */
    public function testCodeDescriptionIsMutable()
    {
        $this->code->setDescription('NAME');
        $this->assertAttributeSame('NAME', 'description', $this->code);
        $this->assertSame('NAME', $this->code->getDescription());
    }


    public function testCodeGroupsIsMutable()
    {
        $group = Mockery::mock('Accard\Component\Diagnosis\Model\CodeGroupInterface');

        $this->code->addGroup($group);
       
        $this->assertEquals($this->code->getGroups()->count(),1);

    }

}