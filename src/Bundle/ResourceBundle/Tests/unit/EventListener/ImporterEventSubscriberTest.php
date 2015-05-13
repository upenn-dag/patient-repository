<?php
namespace AccardTest\Bundle\ResourceBundle\EventListener;

/**
 * Importer Event Subscriber
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\EventListener\ImporterEventSubscriber;
use Accard\Bundle\ResourceBundle\Import\Events;
use Mockery;

class ImporterEventSubscriberTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->subscriber = new ImporterEventSubscriber();
    }

    // tests
    public function testEventListenerGetSubscribedEventsReturnsTheCorrectPreImport()
    {
        $subscribedEvents = [
            Events::PRE_IMPORT => ['initializeImport', 255],
        ];

        $this->assertArrayHasKey(Events::PRE_IMPORT, ImporterEventSubscriber::getSubscribedEvents());
        $this->assertSame($subscribedEvents, ImporterEventSubscriber::getSubscribedEvents());
    }

    public function testEventListenerInitializedImport()
    {
        $criteria = ['CRITERIA'];
        $importerName = 'IMPORTER_NAME';

        $importer = Mockery::mock()
            ->shouldReceive('getCriteria')->once()->andReturn($criteria)
            ->shouldReceive('getName')->once()->andReturn($importerName)
            ->getMock()
        ;

        $import = Mockery::mock()
            ->shouldReceive('setImporter')->once()->with($importerName)
            ->shouldReceive('setCriteria')->once()->with($criteria)
            ->getMock()
        ;

        $event = Mockery::mock('Accard\Bundle\ResourceBundle\Event\ImportEvent')
            ->shouldReceive('getImport')->once()->andReturn($import)
            ->shouldReceive('getHistory')->once()->andReturn(['HISTORY'])
            ->shouldReceive('getImporter')->once()->andReturn($importer)
            ->getMock()
        ;

        $this->subscriber->initializeImport($event);
    }

    public function testEventListenerInitializedImportAsksImporterForDefaultCriteriaWhenEventHistoryEmpty()
    {
        $criteria = ['DEFAULT_CRITERIA'];
        $importerName = 'IMPORTER_NAME';

        $importer = Mockery::mock()
            ->shouldReceive('getDefaultCriteria')->once()->andReturn($criteria)
            ->shouldReceive('getName')->once()->andReturn($importerName)
            ->getMock()
        ;

        $import = Mockery::mock()
            ->shouldReceive('setImporter')->once()->with($importerName)
            ->shouldReceive('setCriteria')->once()->with($criteria)
            ->getMock()
        ;

        $event = Mockery::mock('Accard\Bundle\ResourceBundle\Event\ImportEvent')
            ->shouldReceive('getImport')->once()->andReturn($import)
            ->shouldReceive('getHistory')->once()->andReturn([])
            ->shouldReceive('getImporter')->once()->andReturn($importer)
            ->getMock()
        ;

        $this->subscriber->initializeImport($event);
    }

    public function testEventListenerConvertRecords()
    {
        $target = Mockery::mock()
            ->shouldReceive('getRepository')->once()
            ->getMock()
        ;

        $importer = Mockery::mock()
            ->shouldReceive('getName')
            ->getMock()
        ;

        $event = Mockery::mock('Accard\Bundle\ResourceBundle\Event\ImportEvent')
            ->shouldReceive('getRecords')->andReturn([])
            ->shouldReceive('getTarget')->andReturn($target)
            ->shouldReceive('getImporter')->andReturn($importer)
            ->shouldReceive('setRecords')
            ->getMock()
        ;

        $this->subscriber->convertRecords($event);
    }
}