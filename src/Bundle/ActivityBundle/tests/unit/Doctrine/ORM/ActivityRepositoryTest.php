<?php
namespace AccardTest\Bundle\ActivityBundle\Doctrine\ORM;

/**
 * Activity Repository
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ActivityBundle\Doctrine\ORM\ActivityRepository;
use Mockery;

class ActivityRepositoryTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->class = Mockery::mock('Doctrine\ORM\Mapping\ClassMetadata');
        $this->class->name = "DAG\Bundle\ResourceBundle\Test\Stub\Stub";

        $this->query = Mockery::Mock('Doctrine\ORM\AbstractQuery')
            ->shouldReceive('setParameters')->andReturn(Mockery::self())
            ->shouldReceive('setFirstResult')->andReturn(Mockery::self())
            ->shouldReceive('setMaxResults')->andReturn(Mockery::self())
            ->getMock();

        $this->em = Mockery::mock('Doctrine\ORM\EntityManager')
            ->shouldReceive('getRepository')
            ->shouldReceive('getClassMetadata')->andReturn($this->class)
            ->shouldReceive('createQuery')->andReturn($this->query)
            ->shouldReceive('persist')->andReturn(null)
            ->shouldReceive('flush')->andReturn(null)
            ->getMock()
        ;
        $this->repository = new ActivityRepository($this->em, $this->class);
    }

    // tests
    public function testActivityRepositoryAdheresToActivityRepositoryInterface()
    {
        $this->assertInstanceOf('Accard\Component\Activity\Repository\ActivityRepositoryInterface', $this->repository);
    }

    public function testActivityRepositoryGetAliasReturnsCorrectName()
    {
        $this->assertEquals('activity', $this->repository->getAlias());
    }
}
