<?php
namespace AccardTest\Bundle\ResourceBundle\Form\DataTransformer;

/**
 * Object Identifier Transformer Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Form\DataTransformer\ObjectToIdentifierTransformer;
use Accard\Bundle\ResourceBundle\Test\Stub\Stub;
use Mockery;

class ObjectToIdentifierTransformerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->objRepository = Mockery::mock('Doctrine\Common\Persistence\ObjectRepository');
        $this->identifier = 'id';

        $this->transformer = new ObjectToIdentifierTransformer($this->objRepository, $this->identifier);
    }
 
    public function testObjectToIdentifierTransformerTransformReturnsNullIfNotPresent()
    {
        $this->assertEquals(null, $this->transformer->transform(null));
    }

    public function testObjectToIdentifierTransformerTransformReturnsEntity()
    {
        $value = 'VALUE';

        $this->objRepository->shouldReceive('findOneBy')->with([ 'id' => $value ])->andReturn('SUCCESS');

        $this->assertEquals('SUCCESS', $this->transformer->transform($value));
    }

    public function testObjectToIdentifierTransformerTransformThrowsExceptionIfRepositoryResultReturnsNull()
    {
        $value = 'VALUE';

        $this->objRepository
            ->shouldReceive('findOneBy')->andReturn(null)
            ->shouldReceive('getClassName')
        ;

        $this->setExpectedException('Symfony\Component\Form\Exception\TransformationFailedException');

        $this->transformer->transform($value);
    }

    public function testObjectToIdentifierTransformerReverseTransformReturnsNullIfValuePresentedIsNull()
    {
        $this->assertEquals(null, $this->transformer->transform(null));
    }

    public function testObjectToIdentifierTransformerReverseTransformThrowsExceptionWhenClassNotEqualToValue()
    {
        $value = 'BAD_CLASS';

        $this->objRepository
            ->shouldReceive('getClassName')->andReturn('NOT_MATCHING')
        ;

        $this->setExpectedException('Symfony\Component\Form\Exception\UnexpectedTypeException');

        $this->transformer->reverseTransform($value);
    }

    public function testObjectToIdentifierTransformerReverseTransformReturnsValueIfParametersCorrect()
    {
        $value = new Stub();

        $this->objRepository->shouldReceive('getClassName')->andReturn('Accard\Bundle\ResourceBundle\Test\Stub\Stub');

        $this->assertEquals(1, $this->transformer->reverseTransform($value));
    }
}