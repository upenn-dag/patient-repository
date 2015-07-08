<?php
namespace Accard\Component\Resource\tests\unit\Model;

/**
 * Resource model tests
 * 
 * @author Karl Zipser <kzipser@mail.med.upenn.edu>
 */
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Resource\Model\Import;
use DateInterval;
use Mockery;

class ImportTest extends \Codeception\TestCase\Test
{
	protected $import;

    protected function _before()
    {
        $this->import = new Import();
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
            'Accard\Component\Resource\Model\ImportInterface',
            $this->import
        );
    } 
       
    public function testGetIdReturnsNullValue()
    {
		$this->assertNull($this->import->getId());
    }
       
    public function testIsActiveIsTrue()
    {
    	$test = true;
    	$this->import->setActive ($test);
		$this->assertTrue($this->import->isActive());
    }    
       
    public function testIsActiveIsNotTrue()
    {
    	$test = false;
    	$this->import->setActive ($test);
		$this->assertFalse($this->import->isActive());
    } 

    public function testGetStartTimestampReturnsMicrotime()
    {
    	$test = microtime(true);
		$this->assertEquals($test,$this->import->getStartTimestamp());
    }     

    public function testGetEndTimestampReturnsMicrotime()
    {
    	$test = null;
    	$this->import->setEndTimestamp($test);
		$this->assertSame(microtime(true),$this->import->getEndTimestamp());
    }

    public function testGetEndTimestampReturnsEnteredValue()
    {
    	$test = 'abc';
    	$this->import->setEndTimestamp($test);
		$this->assertSame($test,$this->import->getEndTimestamp());
    }  

    public function testGetDurationReturnsNegativeNumber()
    {
   		$test = microtime(true);
    	$this->import->setEndTimestamp($test);
		$this->assertLessThan($test,$this->import->getDuration());
    }
    
    public function testGetDurationAsIntervalReturnsInterval()
    {
   		$test = microtime(true);
    	$this->import->setEndTimestamp($test);
    	$testclass = new Import();
    	$testclass->setEndTimestamp($test);
		//$this->assertSame(new DateInterval('PT'.round($testdi->getDuration()).'S'),$this->import->getDurationAsInterval());
		$this->assertEquals($testclass->getDurationAsInterval(),$this->import->getDurationAsInterval());
    }
	
    public function testGetCriteriaReturnsArray()
    {
    	$test = ['a','b','c'];
    	$this->import->setCriteria($test);
		$this->assertSame($test,$this->import->getCriteria());
    }

}