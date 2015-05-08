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

    /**
     * All methods from interface are implemented
     */
    public function testClassInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Sample\Model\SourceInterface',
            $this->source
        );
    }

    public function testSourceDerivativesAreEmptyCollectionOnClassConstruct()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->source->getDerivatives()
        );
 
        $this->assertEquals(0, $this->sample->getDerivatives()->count());
    }    
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