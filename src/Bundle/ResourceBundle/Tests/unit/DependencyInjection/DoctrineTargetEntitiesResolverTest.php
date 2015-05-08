<?php
namespace AccardTest\Bundle\ResourceBundle\DependencyInjection;

/**
 * Doctrine Target Entities Resolver
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\DependencyInjection\DoctrineTargetEntitiesResolver;
use Mockery;

class DoctrineTargetEntitiesResolverTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->container = Mockery::mock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $this->entitiesResolver = new DoctrineTargetEntitiesResolver();
    }

    protected function _after()
    {
    }

    public function testEntitiesResolverCanResolveInterfacesAndModelsOutOfTheContainerBuilder()
    {
        $interfaces = ['INTERFACE' => 'MODEL'];
        $parameter = 'RESOLVED_INTERFACE';

        $listener = Mockery::mock()
            ->shouldReceive('addMethodCall')->once()->with('addResolveTargetEntity', [$parameter, $parameter, []])
            ->shouldReceive('hasTag')->once()->andReturn(true)
            ->getMock()
        ;

        $this->container
            ->shouldReceive('hasDefinition')->andReturn(true)->once()
            ->shouldReceive('findDefinition')->andReturn($listener)->once()
            ->shouldReceive('hasParameter')->andReturn(true)->twice()
            ->shouldReceive('getParameter')->andReturn($parameter)->twice()
        ;


        $this->entitiesResolver->resolve($this->container, $interfaces);
    }

    public function testEntitiesResolverCanResolveMultipleInterfacesAtOnce()
    {
        $interfaces = [
            'INTERFACE_0' => 'MODEL_0',
            'INTERFACE_1' => 'MODEL_1',
        ];
        $parameter = 'RESOLVED_INTERFACE';

        $listener = Mockery::mock()
            ->shouldReceive('addMethodCall')->twice()->with('addResolveTargetEntity', [$parameter, $parameter, []])
            ->shouldReceive('hasTag')->once()->andReturn(true)
            ->getMock()
        ;

        $this->container
            ->shouldReceive('hasDefinition')->andReturn(true)
            ->shouldReceive('findDefinition')->andReturn($listener)
            ->shouldReceive('hasParameter')->andReturn(true)->times(4)
            ->shouldReceive('getParameter')->andReturn($parameter)->times(4)
        ;

        $this->entitiesResolver->resolve($this->container, $interfaces);
    }

    public function testEntitiesResolverThrowsExceptionWhenContainerDoesNotFindTheDoctrineDefinition()
    {
        $this->container
            ->shouldReceive('hasDefinition')->once()->andReturn(false);
        $interfaces = array();

        $this->setExpectedException('RuntimeException');

        $this->assertEmpty($this->entitiesResolver->resolve($this->container, $interfaces));
    }

    public function testEntitiesResolverReturnsKeyIfItIsAnInterface()
    {
        $stubInterface = 'Accard\Bundle\ResourceBundle\Test\Stub\StubInterface';
        $stubModel = 'Accard\Bundle\ResourceBundle\Test\Stub\Stub';
        $interfaces = [ $stubInterface => $stubModel ];

        $listener = Mockery::mock()
            ->shouldReceive('addMethodCall')->once()->with('addResolveTargetEntity', [$stubInterface, $stubModel, []])
            ->shouldReceive('hasTag')->once()->andReturn(true)
            ->getMock()
        ;

        $this->container
            ->shouldReceive('hasDefinition')->andReturn(true)
            ->shouldReceive('findDefinition')->andReturn($listener)
            ->shouldReceive('hasParameter')->andReturn(false)->times(2)
        ;

        $this->assertEmpty($this->entitiesResolver->resolve($this->container, $interfaces));
    }


    public function testEntitiesResolverReturnsKeyIfItIsAnModel()
    {
        $beninInterface = 'BENIEN_INTERFACE';
        $stubModel = 'Accard\Bundle\ResourceBundle\Test\Stub\Stub';
        $interfaces = [ $beninInterface => $stubModel ];

        $listener = Mockery::mock()
            ->shouldReceive('addMethodCall')->once()->with('addResolveTargetEntity', [$beninInterface, $stubModel, []])
            ->shouldReceive('hasTag')->once()->andReturn(true)
            ->getMock()
        ;

        $this->container
            ->shouldReceive('hasDefinition')->andReturn(true)
            ->shouldReceive('findDefinition')->andReturn($listener)
            ->shouldReceive('hasParameter')->andReturn(true)->once()
            ->shouldReceive('getParameter')->andReturn($beninInterface)
            ->shouldReceive('hasParameter')->andReturn(false)->once()
        ;

        $this->assertEmpty($this->entitiesResolver->resolve($this->container, $interfaces));
    }

    public function testEntitiesResolverThrowsExceptionWhenInterfaceDoesNotExist()
    {
        $badInterface = "I_AM_A_VERY_BAD_INTERFACE";
        $goodModel = "Accard\Bundle\ResourceBundle\Test\Stub\Stub";
        $interfaces = [ $badInterface => $goodModel ];

        $listener = Mockery::mock();

        $this->container
            ->shouldReceive('hasDefinition')->andReturn(true)
            ->shouldReceive('findDefinition')->andReturn($listener)
            ->shouldReceive('hasParameter')->andReturn(false)->once()
        ;

        $this->setExpectedException('InvalidArgumentException');

        $this->entitiesResolver->resolve($this->container, $interfaces);

    }

    public function testEntitiesResolverThrowsExceptionWhenModelDoesNotExist()
    {
        $goodInterface = "Accard\Bundle\ResourceBundle\Test\Stub\Stub";
        $badModel = "I_AM_A_VERY_BAD_MODEL";
        $interfaces = [ $goodInterface => $badModel ];

        $listener = Mockery::mock();

        $this->container
            ->shouldReceive('hasDefinition')->andReturn(true)
            ->shouldReceive('findDefinition')->andReturn($listener)
            ->shouldReceive('hasParameter')->andReturn(false)->once()
        ;

        $this->setExpectedException('InvalidArgumentException');

        $this->entitiesResolver->resolve($this->container, $interfaces);

    }
}