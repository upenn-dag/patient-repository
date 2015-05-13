<?php
namespace AccardTest\Bundle\ResourceBundle\Form\DataTransformer;

/**
 * Identifier To Object Transformer Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Form\DataTransformer\IdentifierToObjectTransformer;
use Accard\Bundle\ResourceBundle\Test\Stub\Stub;
use Mockery;

class IdentifierToObjectTransformerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->repository  = Mockery::mock('Doctrine\Common\Persistence\ObjectRepository');
        $this->identifier  = 'id';

        $this->transformer = new IdentifierToObjectTransformer($this->repository, $this->identifier);
    }

    public function testIdentifierToObjectTransformerTransformsReturnsEmptyStringIfNoValueProvided()
    {
        $this->assertEmpty($this->transformer->transform(null));
    }

    public function testIdentifierToObjectTransformerTransformsReturnsValuesIdentifier()
    {
    	$class = 'Accard\Bundle\ResourceBundle\Test\Stub\Stub';

    	$stub = new Stub();

    	$this->repository
    		->shouldReceive('getClassName')
    		->andReturn($class)
    	;

    	$this->assertEquals(1, $this->transformer->transform($stub));
    }

    public function testIdentifierToObjectTransformerTransformsThrowsExceptionWhenValueNotInstanceOfClass()
    {
    	$class = 'BAD_CLASS_NAME';

    	$stub = new Stub();

    	$this->repository
    		->shouldReceive('getClassName')
    		->andReturn($class)
    	;

    	$this->setExpectedException('Symfony\Component\Form\Exception\UnexpectedTypeException');

    	$this->transformer->transform($stub);
    }

    public function testIdentifierToObjectTransformerReverseTransformReturnsEmptyStringWhenNoValuePresent()
    {
    	$this->assertEmpty($this->transformer->reverseTransform(null));
    }

    public function testIdentifierToObjectTransformerReverseTransformerThrowsExceptionWhenInstanceNotInRepository()
    {
    	$value = 'BAD_VALUE';

    	$this->repository
    		->shouldReceive('findOneBy')->with([$this->identifier => $value])
    		->shouldReceive('getClassName')
    		->andReturn(null)
    	;

    	$this->setExpectedException('Symfony\Component\Form\Exception\TransformationFailedException');

    	$this->transformer->reverseTransform($value);
    }

    public function testIdentifierToObjectTransformerTransformsReturnsEntityFromValue()
    {
    	$value = 'GOOD_VALUE';

    	$this->repository
    		->shouldReceive('findOneBy')->with([$this->identifier => $value])
    		->andReturn('ENTITY')
    	;

    	$this->assertEquals('ENTITY', $this->transformer->reverseTransform($value));
    }
}