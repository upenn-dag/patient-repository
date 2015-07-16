<?php
namespace Accard\Component\Sample\tests\unit\Model;

/**
 * Sample model tests
 * 
 * @author Karl Zipser <kzipser@mail.med.upenn.edu>
 */
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Sample\Model\Sample;
use Mockery;

class SampleTest extends \Codeception\TestCase\Test
{
    use \Accard\Component\Prototype\Model\PrototypeSubjectTrait;
    use \Accard\Component\Field\Model\FieldSubjectTrait;
        
    protected $sample;

    protected function _before()
    {
        $this->sample = new Sample();
    }

    protected function _after()
    {
    }


    /**
     * All methods from interface are implemented
     */
    public function testClassInterfaceIsFollowed()

    
    public function testSampleImplementsInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Sample\Model\SampleInterface',
            $this->sample
        );
    }
    

    public function testSampleDerivativesAreEmptyCollectionOnClassConstruct()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->sample->getDerivatives()
        );
 
        $this->assertEquals(0, $this->sample->getDerivatives()->count());
    }

    public function testGetIdReturnsNullValue()
    {
		$this->assertNull($this->sample->getId());
    }
    
    public function testGetSourceReturnsValue()
    {
        $sourceinterface = Mockery::mock('Accard\Component\Sample\Model\SourceInterface');
        $this->sample->setSource($sourceinterface);
        $this->assertSame($this->sample->getSource(), $sourceinterface);    
    }
    
    public function testSetSourceSetsValue()
    {
        $sourceinterface = Mockery::mock('Accard\Component\Sample\Model\SourceInterface');
        $this->sample->setSource($sourceinterface);
        $this->assertInstanceOf(
            'Accard\Component\Sample\Model\SourceInterface',
            $this->sample->getSource()
        );
    }    
        
    public function testGetAmountAndSetAmount()
    {
    	$this->sample->setAmount(1);
    	$this->assertNotEmpty($this->sample->getAmount());
    }
    
    public function testAddDerivativesAlsoHasDerivatives()
    {
        $sourceinterface = Mockery::mock('Accard\Component\Sample\Model\SourceInterface');
        $this->sample->addDerivative($sourceinterface);
        $this->assertTrue($this->sample->hasDerivatives());    	 
    }

    public function testRemoveDerivativeRemovesDerivative()
    {
        $sourceinterface = Mockery::mock('Accard\Component\Sample\Model\SourceInterface');
        $this->sample->addDerivative($sourceinterface);
        $this->sample->removeDerivative($sourceinterface); 
        $this->assertFalse($this->sample->hasDerivatives());  
    }    
    
}