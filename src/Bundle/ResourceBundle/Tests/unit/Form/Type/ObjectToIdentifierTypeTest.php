<?php
namespace AccardTest\Bundle\ResourceBundle\Form\Type;

/**
 * Object To Identifier Type Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Form\Type\ObjectToIdentifierType;
use Mockery;

class ObjectToIdentifierTypeTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->manager = Mockery::mock('Doctrine\Common\Persistence\ManagerRegistry');
        $this->type = new ObjectToIdentifierType($this->manager, 'NAME');
    }

    public function testObjectToIdentifierTypeBuildFormAddsObjectIdentifierTransformerToBuilder()
    {
        $options = ['class' => 'CLASS_VALUE', 'identifier' => 'IDENTIFIER_VALUE'];

        $builder = Mockery::mock('Symfony\Component\Form\FormBuilderInterface')
            ->shouldReceive('addModelTransformer')
            ->getMock()
        ;
        $repository = Mockery::mock('Doctrine\Common\Persistence\ObjectRepository');

        $this->manager
            ->shouldReceive('getRepository')->with('CLASS_VALUE')->andReturn($repository)
        ;

        $this->assertEmpty($this->type->buildForm($builder, $options));
    }

    public function testObjectToIdentifierTypeResolvesOptionsCorrectly()
    {
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setDefaults')->with(['identifier' => 'id'])->andReturnSelf()
            ->shouldReceive('setAllowedTypes')->with(['identifier' => ['string']])
            ->getMock()
        ;

        $this->assertEmpty($this->type->setDefaultOptions($resolver));
    }

    public function testObjectToIdentifierTypeGetParentReturnsCorrectString()
    {
        $this->assertEquals('entity', $this->type->getParent());
    }

    public function testObjectToIdentifierTypeGetName()
    {
        $this->assertEquals('NAME', $this->type->getName());
    }

}