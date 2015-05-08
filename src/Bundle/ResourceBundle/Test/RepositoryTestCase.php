<?php
namespace Accard\Bundle\ResourceBundle\Test;

use Codeception\TestCase\Test as CodeceptionTestCase;
use Mockery;

class RepositoryTestCase extends CodeceptionTestCase
{
	protected $em;

	protected $class;

	protected $query;

	protected $repository;

	public function __construct()
	{
		$this->class = Mockery::mock('Doctrine\ORM\Mapping\ClassMetadata');
        $this->class->name = "Accard\Bundle\ResourceBundle\Test\Stub\Stub";

        $this->query = Mockery::Mock('Doctrine\ORM\AbstractQuery')
            ->shouldReceive('setParameters')->andReturn(Mockery::self())
            ->shouldReceive('setFirstResult')->andReturn(Mockery::self())
            ->shouldReceive('setMaxResults')->andReturn(Mockery::self())
            ->getMock()
        ;

        $this->em = Mockery::mock('Doctrine\ORM\EntityManager')
            ->shouldReceive('getRepository')
            ->shouldReceive('getClassMetadata')->andReturn($this->class)
            ->shouldReceive('createQuery')->andReturn($this->query)
            ->shouldReceive('persist')->andReturn(null)
            ->shouldReceive('flush')->andReturn(null)
            ->getMock()
        ;
	}
}