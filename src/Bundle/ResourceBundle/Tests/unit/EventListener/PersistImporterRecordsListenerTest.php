<?php
namespace AccardTest\Bundle\ResourceBundle\EventListener;

/**
 * Persit Importer Records Listener Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\EventListener\PersistImporterRecordsListener;
use Mockery;

class PersistImporterRecordsListenerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->listener = new PersistImporterRecordsListener();
    }

    public function testPersistImporterRecordsListenerPersistsRecordsFromEvents()
    {
        $om = Mockery::mock()
            ->shouldReceive('transactional')
            ->shouldReceive('persist')->with('VALUE')
            ->shouldReceive('flush')
            ->getMock()
        ;

        $target = Mockery::mock()
            ->shouldReceive('getManager')->andReturn($om)
            ->getMock()
        ;

        $event = Mockery::mock('Accard\Bundle\ResourceBundle\Event\ImportEvent')
            ->shouldReceive('getTarget')->andReturn($target)
            ->shouldReceive('getRecords')->andReturn(['RECORD' => 'VALUE'])
            ->getMock()
        ;

        $this->assertEmpty($this->listener->persistRecords($event));
    }

    public function testPersistImporterRecordsListenerPersistsImport()
    {
        $import = Mockery::mock()
            ->shouldReceive('setEndTimestamp')
            ->getMock()
        ;

        $om = Mockery::mock()
            ->shouldReceive('transactional')
            ->shouldReceive('persist')->with($import)
            ->getMock()
        ;

        $target = Mockery::mock()
            ->shouldReceive('getManager')->andReturn($om)
            ->getMock()
        ;

        $event = Mockery::mock('Accard\Bundle\ResourceBundle\Event\ImportEvent')
            ->shouldReceive('getTarget')->andReturn($target)
            ->shouldReceive('getImport')->andReturn($import)
            ->getMock()
        ;

        $this->assertEmpty($this->listener->persistImport($event));
    }

    public function testPersistImporterRecordsListenerDisableSQLLogDisablesSQLLog()
    {
        $configuration = Mockery::mock()
            ->shouldReceive('setSQLLogger')->with(null)
            ->getMock()
        ;

        $connection = Mockery::mock()
            ->shouldReceive('getConfiguration')->andReturn($configuration)
            ->getMock()
        ;

        $manager = Mockery::mock()
            ->shouldReceive('getConnection')->andReturn($connection)
            ->getMock()
        ;

        $target = Mockery::mock()
            ->shouldReceive('getManager')->andReturn($manager)
            ->getMock()
        ;

        $event = Mockery::mock('Accard\Bundle\ResourceBundle\Event\ImportEvent')
            ->shouldReceive('getTarget')->andReturn($target)
            ->getMock()
        ;

        $this->assertEmpty($this->listener->disableSQLLog($event));
    }
}