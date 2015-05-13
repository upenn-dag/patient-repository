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
        $resourceName = 'RESOURCE_NAME';

        $managerName = 'accard.manager.RESOURCE';
        $repositoryName = 'accard.repository.RESOURCE';

        $manager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $repo = Mockery::mock('Doctrine\Common\Persistence\ObjectRepository');
        $form = Mockery::mock('Symfony\Component\Form\FormTypeInterface');


        $this->container
            ->shouldReceieve('has')->with($managerName)->once()->andReturn(true)
            ->shouldReceieve('get')->with($managerName)->once()->andReturn($manager)
            ->shouldReceieve('has')->with($repoName)->once()->andReturn(true)
            ->shouldReceieve('get')->with($repoName)->once()->andReturn($repo)
            ->shouldReceieve('has')->with($formName)->once()->andReturn(true)
            ->shouldReceieve('get')->with($formName)->once()->andReturn($form)
        ;

        $this->assertInstanceOf(
            'Accard\Bundle\ResourceBundle\Import\Resource',
            $this->resource->resolveResource($resource, $resourceName)
        );
    }

}