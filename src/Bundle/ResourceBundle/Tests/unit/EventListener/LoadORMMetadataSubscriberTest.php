<?php
namespace AccardTest\Bundle\ResourceBundle\EventListener;

/**
 * Load ORM Metadata Subscriber Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\EventListener\LoadORMMetadataSubscriber;
use Mockery;

class LoadORMMetadataSubscriberTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->class = ['model' => 'MODEL'];
        $this->classes = [$this->class];
        $this->inheritance = Mockery::mock();

        $this->subscriber = new LoadORMMetadataSubscriber($this->classes, $this->inheritance);
    }

    public function testLoadORMMetadataSubscriberAdheresToEventSubscriberInterface()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\EventSubscriber',
            $this->subscriber
        );
    }

    public function testLoadORMMetadataSubscriberGetSubscribedEventsReturnsSomething()
    {
        $this->assertSame(['loadClassMetadata'], $this->subscriber->getSubscribedEvents());
    }

    public function testLoadORMMetadataSubscriberUnsetsSuperClassAssociationMappings()
    {
        $metadata = Mockery::mock('Doctrine\ORM\Mapping\ClassMetadata')
            ->shouldReceive('getName')->andReturn('NAME')
            ->shouldReceive('getAssociationMappings')->andReturn(['ASSOCIATION' => [
                'type' => 'MAPPING']])
            ->getMock();
        ;

        $metadata->isMappedSuperclass = true;
        $metadata->table['name'];

        $entityManager = Mockery::mock()
            ->shouldReceive('getConfiguration')->once()->andReturn(['CONFIGURATION'])
            ->getMock()
        ;

        $eventArgs = Mockery::mock('Doctrine\ORM\Event\LoadClassMetadataEventArgs')
            ->shouldReceive('getClassMetadata')->once()->andReturn($metadata)
            ->shouldReceive('getEntityManager')->once()->andReturn($entityManager)
            ->getMock()
        ;

        $this->subscriber->loadClassMetadata($eventArgs);
    }

    public function testLoadORMMetadataSubscriberSetsAssociationMappingsIfSuperClass()
    {
        $metadata = Mockery::mock('Doctrine\ORM\Mapping\ClassMetadata')
            ->shouldReceive('getName')->andReturn('Accard\Bundle\ResourceBundle\Test\Stub\ChildStub')
            ->shouldReceive('getAssociationMappings')->andReturn([
                'ASSOCIATION' => [
                    'type' => 'MAPPING']
                ])
            ->getMock();
        ;

        $metadata->isMappedSuperclass = false;

        $namingStrategy = Mockery::mock('Doctrine\ORM\Mapping\NamingStrategy');

        $metadataDriverImpl = Mockery::mock()
            ->shouldReceive('getAllClassNames')->andReturn(['PARENT'])
            ->getMock()
        ;

        $configuration = Mockery::mock()
            ->shouldReceive('getNamingStrategy')->andReturn($namingStrategy)
            ->shouldReceive('getMetadataDriverImpl')->andReturn($metadataDriverImpl)
            ->getMock()
        ;

        $entityManager = Mockery::mock()
            ->shouldReceive('getConfiguration')->once()->andReturn($configuration)
            ->getMock()
        ;

        $eventArgs = Mockery::mock('Doctrine\ORM\Event\LoadClassMetadataEventArgs')
            ->shouldReceive('getClassMetadata')->once()->andReturn($metadata)
            ->shouldReceive('getEntityManager')->once()->andReturn($entityManager)
            ->getMock()
        ;

        $this->subscriber->loadClassMetadata($eventArgs);
    }

}