<?php
namespace AccardTest\Bundle\ResourceBundle\Event;

/**
 * Import Accept Event Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Event\ImportAcceptEvent;

class ImportAcceptEventTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->event = new ImportAcceptEvent('RECORD', 'TARGET', 'SIGNAL');
    }

    // tests
    public function testEventRecordIsRetrievable()
    {
        $this->assertSame('RECORD', $this->event->getRecord());
    }

    public function testEventTargetIsRetrievable()
    {
        $this->assertSame('TARGET', $this->event->getTarget());
    }

    public function testEventSignalIsRetrievable()
    {
        $this->assertSame('SIGNAL', $this->event->getSignal());
    }
}