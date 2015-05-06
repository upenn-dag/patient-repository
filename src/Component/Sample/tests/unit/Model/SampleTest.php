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

    /////	TEST IMPLEMENT OF THE INTERFACE /////
    
    public function testSampleImplementsInterface()
    {
		$this->assertTrue(method_exists($this->sample,'getId'));
    }

    public function testGetSourceImplementsInterface()
    {
    	$this->assertTrue(method_exists($this->sample,'getSource'));
    }

    public function testSetSourceImplementsInterface()
    {
    	$this->assertTrue(method_exists($this->sample,'setSource'));
    }

    public function testGetAmountImplementsInterface()
    {
    	$this->assertTrue(method_exists($this->sample,'getAmount'));
    }

    public function testSetAmountImplementsInterface()
    {
    	$this->assertTrue(method_exists($this->sample,'setAmount'));
    }

    public function testGetDerivativesImplementsInterface()
    {
    	$this->assertTrue(method_exists($this->sample,'getDerivatives'));
    }

    public function testHasDerivativeImplementsInterface()
    {
    	$this->assertTrue(method_exists($this->sample,'hasDerivative'));
    }

    public function testHasDerivativesImplementsInterface()
    {
    	$this->assertTrue(method_exists($this->sample,'hasDerivatives'));
    }

    public function testAddDerivativeImplementsInterface()
    {
    	$this->assertTrue(method_exists($this->sample,'addDerivative'));
    }

    public function testRemoveDerivativeImplementsInterface()
    {
    	$this->assertTrue(method_exists($this->sample,'removeDerivative'));
    }
    
    /////	TEST CORRECT FUNCTIONALITY OF THE CLASS METHODS /////
    
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