<?php
namespace AccardTest\Bundle\ResourceBundle\Serializer;

/**
 * Property Handler Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Serializer\PropertyHandler;
use Accard\Bundle\ResourceBundle\Test\Stub\Stub;
use Mockery;

class PropertyHandlerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->handler = new PropertyHandler();
    }

    // tests
    public function testPropertyHandlerAdheresSubscribingHandlerInterface()
    {
        $this->assertInstanceOf('JMS\Serializer\Handler\SubscribingHandlerInterface', $this->handler);
    }

    public function testPropertyHandlerGetSubscribingMethodsReturnsArray()
    {
        $this->assertCount(6, $this->handler->getSubscribingMethods());
        $this->assertInternalType('array', $this->handler->getSubscribingMethods());
    }

    public function testPropertyHandlerSerializePropertyDoesNothingIfDataIsEmpty()
    {
        $visitor = Mockery::mock('JMS\Serializer\VisitorInterface');
        $data = 'NOT_AN_OBJECT';
        $type = [];
        $context = Mockery::mock('JMS\Serializer\Context');

        $this->assertEmpty($this->handler->serializeProperty($visitor, $data, $type, $context));
    }

    public function testPropertyHandlerSerializerPropertyVisitsAndVisitsInteger()
    {
        $data = new Stub();
        $type = [];
        $context = Mockery::mock('JMS\Serializer\Context');
        $visitor = Mockery::mock('JMS\Serializer\VisitorInterface')
            ->shouldReceive('visitString')->andReturn('SUCCESS')
            ->getMock()
        ;

        $this->assertEquals('SUCCESS', $this->handler->serializeProperty($visitor, $data, $type, $context));
    }

    public function testPropertyHandlerDeserializerIdentifier()
    {
        $this->setExpectedException('RuntimeException');

        $data = Mockery::mock();
        $type = [];
        $context = Mockery::mock('JMS\Serializer\Context');
        $visitor = Mockery::mock('JMS\Serializer\VisitorInterface');

        $this->handler->deserializeProperty($visitor, $data, $type, $context);
    }
}