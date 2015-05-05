<?php
namespace Accard\Component\Sample\tests\unit\Model;
/**
 * Source model tests
 * 
 * @author Karl Zipser <kzipser@mail.med.upenn.edu>
 */

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Sample\Model\Source;
use Accard\Component\Sample\Model\Sample;
use Mockery;

class SourceTest extends \Codeception\TestCase\Test
{

	protected $source; 
    protected $sample;

    protected function _before()
    {
        $this->source = new Source();
        $this->sample = new Sample();
    }

    protected function _after()
    {
    }	

    /////	TEST IMPLEMENT OF THE INTERFACE METHODS /////
    
    public function testGetIdImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'getId'));
    }	

    public function testGetSampleImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'getSample'));
    }	

    public function testSetSampleImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'setSample'));
    }

    public function testIsDerivationImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'isDerivation'));
    }

    public function testGetSourceDateImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'getSourceDate'));
    }

    public function testSetSourceDateImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'setSourceDate'));
    }

    public function testGetAmountImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'getAmount'));
    }

    public function testSetAmountImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'setAmount'));
    }

    public function testGetSamplesImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'getSamples'));
    }

    public function testHasSampleImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'hasSample'));
    }

    public function testAddSampleImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'addSample'));
    }

    public function testRemoveSampleImplementsInterface()
    {
		$this->assertTrue(method_exists($this->source,'removeSample'));
    }
    
    /////  TEST CORRECT FUNCTIONALITY OF THE CLASS METHODS /////
    
    public function testGetIdReturnsNullValue()
    {
        $this->assertNull($this->source->getId());
    }

    public function testGetSampleReturnsValue()
    {
        $sampleinterface = Mockery::mock('Accard\Component\Sample\Model\SampleInterface');
        $this->source->setSample($sampleinterface);
        $this->assertSame($this->source->getSample(), $sampleinterface);   
    }
    
    public function testSetSampleSetsValue()
    {
        $sampleinterface = Mockery::mock('Accard\Component\Sample\Model\SampleInterface');
        $this->source->setSample($sampleinterface);
        $this->assertInstanceOf(
            'Accard\Component\Sample\Model\SampleInterface',
            $this->source->getSample()
        );
    }  

    public function testIsDerivationVerify()
    {
        $sampleinterface = Mockery::mock('Accard\Component\Sample\Model\SampleInterface');
        $this->source->setSample($sampleinterface);
        $this->assertTrue($this->source->isDerivation());   
    }

    public function testGetSourceDateGetsValue()
    {
        $datetime = Mockery::mock('DateTime');
        $this->source->setSourceDate($datetime);
        $this->assertInstanceOf(
            'DateTime',
            $this->source->getSourceDate()
        );
    }

    public function testSetSourceDateSetsValue()
    {
        $datetime = Mockery::mock('DateTime');
        $this->source->setSourceDate($datetime);
        $this->assertInstanceOf(
            'DateTime',
            $this->source->getSourceDate()
        );
    } 

    public function testGetAmountAndSetAmount()
    {
        $this->source->setAmount(1);
        $this->assertNotEmpty($this->source->getAmount());
    }
    
    public function testAddSampleAlsoHasSample()
    {
        $sampleinterface = Mockery::mock('Accard\Component\Sample\Model\SampleInterface');
        $this->source->addSample($this->sample);
        $this->assertTrue($this->source->hasSample($this->sample));      
    }    

    public function testRemoveSampleRemovesSample()
    {
        $sampleinterface = Mockery::mock('Accard\Component\Sample\Model\SampleInterface');
        $this->source->addSample($this->sample);
        $this->source->removeSample($this->sample); 
        $this->assertFalse($this->source->hasSample($this->sample));  
    }        
}