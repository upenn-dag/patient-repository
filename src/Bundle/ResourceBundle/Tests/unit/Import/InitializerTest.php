<?php
namespace AccardTest\Bundle\ResourceBundle\Import;

/**
 * Initializer Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\Initializer;
use Mockery;

class InitializerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->initializer = new Initializer();
    }

    public function testInitializerInitializeAdheresToInitializerInterface()
    {
        $this->assertInstanceOf(
            'Accard\Bundle\ResourceBundle\Import\InitializerInterface',
            $this->initializer
        );
    }

    public function testInitializerInitializeRetrievesDefaultCriteriaIfEventHistoryIsEmpty()
    {

        $importer = Mockery::mock()
            ->shouldReceive('getName')->andReturn('NAME')
            ->shouldReceive('getDefaultCriteria')->once()->andReturn('DEFAULT_CRITERIA')
            ->shouldReceive('getCriteria')->never()
            ->getMock()
        ;

        $import = Mockery::mock()
            ->shouldReceive('setImporter')->with('NAME')
            ->shouldReceive('setCriteria')->with('DEFAULT_CRITERIA')
            ->getMock()
        ;

        $event = Mockery::mock('Accard\Bundle\ResourceBundle\Event\ImportEvent')
            ->shouldReceive('getImport')->andReturn($import)
            ->shouldReceive('getHistory')->andReturn([])
            ->shouldReceive('getImporter')->andReturn($importer)
            ->getMock()
        ;


        $this->assertEmpty($this->initializer->initialize($event));
    }

    public function testInitializerInitializeRetrievesCriteriaIfEventHistoryIsPresent()
    {

        $importer = Mockery::mock()
            ->shouldReceive('getName')->andReturn('NAME')
            ->shouldReceive('getDefaultCriteria')->never()
            ->shouldReceive('getCriteria')->andReturn('CRITERIA')
            ->getMock()
        ;

        $import = Mockery::mock()
            ->shouldReceive('setImporter')->with('NAME')
            ->shouldReceive('setCriteria')->with('CRITERIA')
            ->getMock()
        ;

        $event = Mockery::mock('Accard\Bundle\ResourceBundle\Event\ImportEvent')
            ->shouldReceive('getImport')->andReturn($import)
            ->shouldReceive('getHistory')->andReturn('HISTORY')
            ->shouldReceive('getImporter')->andReturn($importer)
            ->getMock()
        ;


        $this->assertEmpty($this->initializer->initialize($event));
    }
}