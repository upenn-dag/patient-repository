<?php
namespace Accard\Component\Resource\tests\unit\Model;

/**
 * Resource model tests
 * 
 * @author Karl Zipser <kzipser@mail.med.upenn.edu>
 */
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Resource\Model\Log;
use DateTime;
use Mockery;

class LogTest extends \Codeception\TestCase\Test
{
    protected $log;

    protected function _before()
    {
        $this->log = new Log();
    }

    protected function _after()
    {
    }

    /**
     * All methods from interface are implemented
     */
    public function testClassInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\LogInterface',
            $this->log
        );
    }

    public function testGetIdReturnsNullValue()
    {
        $this->assertNull($this->log->getId());
    }

    public function testGetUserWithSetUserReturnsUser()
    {
        $userinterface = Mockery::mock('Accard\Component\Resource\Model\UserInterface');
        $this->log->setUser($userinterface);        
        $this->assertSame($userinterface, $this->log->getUser());  
    }

    public function testGetLogDateUsesSetLogDateToReturnLogDate()
    {  
        $test = new DateTime;
        $this->log->setLogDate($test);        
        $this->assertInstanceOf('DateTime', $this->log->getLogDate());  
    }   

    public function testGetActionUsesSetActionToReturnValue()
    {  
        $test = 'abc';
        $this->log->setAction($test);
        $this->assertSame($test,$this->log->getAction());
    }   

    public function testGetResourceUsesSetResourceToReturnValue()
    {  
        $test = 'abc';
        $this->log->setResource($test);
        $this->assertSame($test,$this->log->getResource());
    }

    public function testGetResourceIdUsesSetResourceIdToReturnValue()
    {  
        $test = 123;
        $this->log->setResourceId($test);
        $this->assertSame($test,$this->log->getResourceId());
    }

    public function testGetRouteUsesSetRouteToReturnValue()
    {  
        $test = 'abc';
        $this->log->setRoute($test);
        $this->assertSame($test,$this->log->getRoute());
    }

    public function testGetAttributesUsesSetAttributesToReturnArray()
    {  
        $test = ['a','b','c'];
        $this->log->setAttributes($test);
        $this->assertSame($test,$this->log->getAttributes());
    }

    public function testGetQueryUsesSetQueryToReturnArray()
    {  
        $test = ['a','b','c'];
        $this->log->setQuery($test);
        $this->assertSame($test,$this->log->getQuery());
    }

    public function testGetRequestUsesSetRequestToReturnArray()
    {  
        $test = ['a','b','c'];
        $this->log->setRequest($test);
        $this->assertSame($test,$this->log->getRequest());
    }
}