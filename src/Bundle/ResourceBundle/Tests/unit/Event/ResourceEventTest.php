<?php
namespace AccardTest\Bundle\ResourceBundle\Event;

/**
 * Resource Event Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Event\ResourceEvent;

class ResourceEventTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->event = new ResourceEvent();
    }

    public function testResourceEventStopAcceptsParametersAndAssignsThemCorrectly()
    {
        $message = 'MESSAGE';
        $parameters = ['PARAMETER_0', 'PARAMETER_1'];
        $message_type = 'TEST';

        $this->event->stop($message, $message_type, $parameters);

        $this->assertSame($this->event->getMessage(), $message);
        $this->assertSame($this->event->isStopped(), true);
        $this->assertSame($this->event->getMessageType(), $message_type);
        $this->assertSame($this->event->getMessageParameters(), $parameters);
    }
}