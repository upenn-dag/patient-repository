<?php
namespace AccardTest\Bundle\ResourceBundle\Import;

/**
 * Resource Resolving Factory Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Mockery;
use Accard\Bundle\ResourceBundle\Import\ResourceResolvingFactory;

class ResourceResolvingFactoryTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->factory = new ResourceResolvingFactory();

        $this->container = Mockery::mock('Symfony\Component\DependencyInjection\ContainerInterface');
        $this->factory->setContainer($this->container);
    }

    public function testResourceResolvingFactoryResolveResourceReturnsResource()
    {
        $resource = 'RESOURCE';
        $resourceType = 1;

        $managerName = 'accard.manager.RESOURCE';
        $repositoryName = 'accard.repository.RESOURCE';
        $formName = 'accard.form.type.RESOURCE';

        $manager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $repo = Mockery::mock('Doctrine\Common\Persistence\ObjectRepository');
        $form = Mockery::mock('Symfony\Component\Form\FormTypeInterface');

        $this->container
            ->shouldReceive('has')->with($managerName)->once()->andReturn(true)
            ->shouldReceive('get')->with($managerName)->once()->andReturn($manager)
            ->shouldReceive('has')->with($repositoryName)->once()->andReturn(true)
            ->shouldReceive('get')->with($repositoryName)->once()->andReturn($repo)
            ->shouldReceive('has')->with($formName)->once()->andReturn(true)
            ->shouldReceive('get')->with($formName)->once()->andReturn($form)
        ;

        $this->assertInstanceOf(
            'Accard\Bundle\ResourceBundle\Import\Resource',
            $this->factory->resolveResource($resource, $resourceType)
        );
    }

    public function testResourceResolvingFactoryResolveSubjectReturnsResource()
    {
        $resource = 'RESOURCE';
        $resourceType = 1;

        $managerName = 'accard.manager.RESOURCE';
        $repositoryName = 'accard.repository.RESOURCE';
        $formName = 'accard.form.type.RESOURCE';

        $manager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $repo = Mockery::mock('Doctrine\Common\Persistence\ObjectRepository');
        $form = Mockery::mock('Symfony\Component\Form\FormTypeInterface');

        $this->container
            ->shouldReceive('has')->with($managerName)->once()->andReturn(true)
            ->shouldReceive('get')->with($managerName)->once()->andReturn($manager)
            ->shouldReceive('has')->with($repositoryName)->once()->andReturn(true)
            ->shouldReceive('get')->with($repositoryName)->once()->andReturn($repo)
            ->shouldReceive('has')->with($formName)->once()->andReturn(true)
            ->shouldReceive('get')->with($formName)->once()->andReturn($form)
        ;

        $this->assertInstanceOf(
            'Accard\Bundle\ResourceBundle\Import\Resource',
            $this->factory->resolveResource($resource, $resourceType)
        );

        $this->factory->resolveSubject($resource);
    }

    public function testResourceResolvingFactoryResolveTargetReturnsResource()
    {
        $resource = 'RESOURCE';
        $resourceType = 2;

        $managerName = 'accard.manager.RESOURCE';
        $repositoryName = 'accard.repository.RESOURCE';
        $formName = 'accard.form.type.RESOURCE';

        $manager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $repo = Mockery::mock('Doctrine\Common\Persistence\ObjectRepository');
        $form = Mockery::mock('Symfony\Component\Form\FormTypeInterface');

        $this->container
            ->shouldReceive('has')->with($managerName)->once()->andReturn(true)
            ->shouldReceive('get')->with($managerName)->once()->andReturn($manager)
            ->shouldReceive('has')->with($repositoryName)->once()->andReturn(true)
            ->shouldReceive('get')->with($repositoryName)->once()->andReturn($repo)
            ->shouldReceive('has')->with($formName)->once()->andReturn(true)
            ->shouldReceive('get')->with($formName)->once()->andReturn($form)
        ;

        $this->assertInstanceOf(
            'Accard\Bundle\ResourceBundle\Import\Resource',
            $this->factory->resolveResource($resource, $resourceType)
        );

        $this->factory->resolveSubject($resource);
    }
}