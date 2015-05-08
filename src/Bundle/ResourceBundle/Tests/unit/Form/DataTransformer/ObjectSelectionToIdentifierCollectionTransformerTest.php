<?php
namespace AccardTest\Bundle\ResourceBundle\Form\DataTransformer;

/**
 * Object Selection To Identifier Collection Transformer Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Form\DataTransformer\ObjectSelectionToIdentifierCollectionTransformer;
use Accard\Bundle\ResourceBundle\Test\Stub\Stub;
use Mockery;

class ObjectSelectionToIdentifierCollectionTransformerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->saveObjects = true;

        $this->transformer = new ObjectSelectionToIdentifierCollectionTransformer($this->saveObjects);
    }

    public function testObjectSelectionToIdentifierCollectionTransformerAdheresToDataTransformerInterface()
    {
        $this->assertInstanceOf(
            'Symfony\Component\Form\DataTransformerInterface',
            $this->transformer
        );
    }

    public function testObjectSelectionToIdentifierCollectionTransformerTransformReturnsEmptyArrayIfNoValuePresent()
    {
        $this->assertEquals([], $this->transformer->transform(null));
    }

    public function testObjectSelectionToIdentifierCollectionTransformerTransformThrowsExceptionIfValueInstanceNotOfACollection()
    {
        $value = 'BAD_VALUE';

        $this->setExpectedException('Symfony\Component\Form\Exception\UnexpectedTypeException');

        $this->transformer->transform($value);
    }

    public function testObjectSelectionToIdentifierCollectionTransformerTransformConvertsCollectionsToArrays()
    {
        $testArray = ['ARRAY_HERE'];
        $value = Mockery::mock('Doctrine\Common\Collections\Collection')
            ->shouldReceive('toArray')->andReturn($testArray)
            ->getMock()
        ;

        $this->assertSame($testArray, $this->transformer->transform($value));
    }

    public function testObjectSelectionToIdentifierCollectionTransformerReverseTransformReturnsNewArrayCollectionIfValueNull()
    {
        $value = null;

        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->transformer->reverseTransform($value));
    }

    public function testObjectSelectionToIdentifierCollectionTransformerReverseTransformThrowsExceptionWhenNotArray()
    {
        $value = 'STRING';
        $this->setExpectedException('Symfony\Component\Form\Exception\UnexpectedTypeException');

        $this->transformer->reverseTransform($value);
    }

    public function testObjectSelectionToIdentifierCollectionTransformerReverseTransformSavesObjectsIfFlagTrue()
    {
        $mock0 = Mockery::mock();

        $value = [$mock0];

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->transformer->reverseTransform($value)
        );
    }

    public function testObjectSelectionToIdentifierCollectionTransformerReverseTransformGetsObjectIdsIfSaveObjectsTrue()
    {
        $mock0 = Mockery::mock()->shouldReceive('getId');

        $value = [$mock0];

        $this->transformer->reverseTransform($value);
    }

    public function testObjectSelectionToIdentifierCollectionTransformerReverseTransformGetsObjectIfSaveObjectsFalse()
    {
        $mock0 = Mockery::mock()->shouldReceive('getId')->never()->getMock();

        $value = [$mock0];

        $transformer = new ObjectSelectionToIdentifierCollectionTransformer(false);

        $transformer->reverseTransform($value);
    }
}