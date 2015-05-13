<?php
namespace AccardTest\Bundle\ResourceBundle\Event;

/**
 * Import Event Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Mockery;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;

class ImportEventTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->subject = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceInterface')
            ->shouldReceive('isSubject')
            ->zeroOrMoreTimes()
            ->andReturn(true)
            ->getMock()
        ;

        $this->target = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceInterface')
            ->shouldReceive('isTarget')
            ->zeroOrMoreTimes()
            ->andReturn(true)
            ->getMock()
        ;

        $this->event = new ImportEvent($this->subject, $this->target);
    }

    public function testImportEventSubjectIsRetrievable()
    {
        $this->assertSame($this->subject, $this->event->getSubject());
    }

    public function testImportEventTargetIsRetrievable()
    {
        $this->assertSame($this->target, $this->event->getTarget());
    }

    public function testImportEventImporterIsMutable()
    {
        $importer = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ImporterInterface');

        $this->event->setImporter($importer);

        $this->assertSame($this->event->getImporter(), $importer);
    }

    public function testImportEventHistoryIsMutable()
    {
        $history = array('HISTORY_0', 'HISTORY_1');

        $this->event->setHistory($history);

        $this->assertSame($this->event->getHistory(), $history);
    }

    public function testImportEventRecordsIsMutable()
    {
        $records = array('RECORD_0', 'RECORD_1');

        $this->event->setRecords($records);

        $this->assertSame($this->event->getRecords(), $records);
    }

    public function testImportEventImportIsNewImportWhenNonePresentDuringCreation()
    {
        $this->assertInstanceOf('Accard\Component\Resource\Model\Import', $this->event->getImport());
    }

    public function testImportEventIsSettableUponCreation()
    {
        $import = Mockery::mock('Accard\Component\Resource\Model\Import');

        $subject = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceInterface')
            ->shouldReceive('isSubject')
            ->zeroOrMoreTimes()
            ->andReturn(true)
            ->getMock()
        ;

        $target = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceInterface')
            ->shouldReceive('isTarget')
            ->zeroOrMoreTimes()
            ->andReturn(true)
            ->getMock()
        ;

        $event = new ImportEvent($subject, $target, $import);

        $this->assertSame($import, $event->getImport());
    }

    public function testImportEventThrowsExceptionIsSubjectIsNotSubject()
    {
        $import = Mockery::mock('Accard\Component\Resource\Model\Import');

        $subject = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceInterface')
            ->shouldReceive('isSubject')
            ->zeroOrMoreTimes()
            ->andReturn(false)
            ->getMock()
        ;

        $target = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceInterface')
            ->shouldReceive('isTarget')
            ->zeroOrMoreTimes()
            ->andReturn(true)
            ->getMock()
        ;

        $this->setExpectedException('Accard\Bundle\ResourceBundle\Exception\ResourceNotSubjectException');

        new ImportEvent($subject, $target, $import);
    }

    public function testImportEventThrowsExceptionIsTargetIsNotSubject()
    {
        $import = Mockery::mock('Accard\Component\Resource\Model\Import');

        $subject = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceInterface')
            ->shouldReceive('isSubject')
            ->zeroOrMoreTimes()
            ->andReturn(true)
            ->getMock()
        ;

        $target = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceInterface')
            ->shouldReceive('isTarget')
            ->zeroOrMoreTimes()
            ->andReturn(false)
            ->getMock()
        ;

        $this->setExpectedException('Accard\Bundle\ResourceBundle\Exception\ResourceNotTargetException');

        new ImportEvent($subject, $target, $import);
    }
}