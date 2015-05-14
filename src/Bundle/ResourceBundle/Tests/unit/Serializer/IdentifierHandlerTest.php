<?php
namespace AccardTest\Bundle\ResourceBundle\Serializer;

/**
 * Identifier Handler Test
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Serializer\IdentifierHandler;
use Accard\Bundle\ResourceBundle\Test\Stub\Stub;
use Mockery;

class IdentifierHandlerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->handler = new IdentifierHandler();
    }

    // tests
    public function testIdenitiferHandlerAdheresToSubscribingHandlerInterface()
    {
        $this->assertInstanceOf(
            'JMS\Serializer\Handler\SubscribingHandlerInterface',
            $this->handler
        );
    }

    public function testIdenitiferHandlerSerializerIdentifierDoesNothingIfDataIsNotObject()
    {
        $visitor = Mockery::mock('JMS\Serializer\VisitorInterface');
        $data = 'NOT_AN_OBJECT';
        $type = [];
        $context = Mockery::mock('JMS\Serializer\Context');

        $this->assertEmpty($this->handler->serializeIdentifier($visitor, $data, $type, $context));
    }

    public function testIdenitiferHandlerSerializerIdentifierVisitsAndVisitsInteger()
    {
        $data = new Stub();
        $type = [];
        $context = Mockery::mock('JMS\Serializer\Context');
        $visitor = Mockery::mock('JMS\Serializer\VisitorInterface')
            ->shouldReceive('visitInteger')->andReturn('SUCCESS')
            ->getMock()
        ;

        $this->assertEquals('SUCCESS', $this->handler->serializeIdentifier($visitor, $data, $type, $context));
    }

    public function testIdentifierHandlerSerializerThrowsCorrectException()
    {
        $data = Mockery::mock();
        $type = [];
        $context = Mockery::mock('JMS\Serializer\Context');
        $visitor = Mockery::mock('JMS\Serializer\VisitorInterface')
            ->shouldReceive('visitInteger')->andReturn('SUCCESS')
            ->getMock()
        ;

        $this->setExpectedException('JMS\Serializer\Exception\UnsupportedFormatException');

        $this->handler->serializeIdentifier($visitor, $data, $type, $context);
    }

    public function testIdentifierHandlerDeserializerIdentifier()
    {
        $this->setExpectedException('RuntimeException');

        $data = Mockery::mock();
        $type = [];
        $context = Mockery::mock('JMS\Serializer\Context');
        $visitor = Mockery::mock('JMS\Serializer\VisitorInterface');

        $this->handler->deserializeIdentifier($visitor, $data, $type, $context);
    }

    public function testIdentifierHandlerGetSubscribingMethods()
    {
        $this->assertCount(6, IdentifierHandler::getSubscribingMethods());
        $this->assertInternalType('array', IdentifierHandler::getSubscribingMethods());
    }
}