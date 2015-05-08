<?php
namespace AccardTest\Bundle\ResourceBundle\Doctrine\ORM;

/**
 * Entity Repository Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Mockery;

class EntityRepositoryTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->class = Mockery::mock('Doctrine\ORM\Mapping\ClassMetadata');
        $this->class->name = "Accard\Bundle\ResourceBundle\Test\Stub\Stub";

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

        $this->repository = new EntityRepository($this->em, $this->class);
    }

    public function testEntityRepositoryAdheresToRepositoryInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Repository\RepositoryInterface',
            $this->repository
        );
    }

    public function testEntityRepositoryCreateNewReturnsNewClass()
    {
        $this->assertInstanceOf(
            'Accard\Bundle\ResourceBundle\Test\Stub\Stub', 
            $this->repository->createNew()
        );
    }

    public function testEntityRepositoryCanFindById()
    {
        $this->query
            ->shouldReceive('getOneOrNullResult')->andReturn(null)
        ;

        $this->repository->find(1);
    }

    public function testEntityRepositoryCanFindAll()
    {
        $this->query
            ->shouldReceive('getResult')->andReturn(null)
        ;

        $this->repository->findAll();
    }

    public function testEntityRepositoryFindOneByShouldAcceptArrayOfCriteria()
    {
        $this->query
            ->shouldReceive('getOneOrNullResult')
            ->shouldReceive('execute');

        $this->repository->findOneBy(['CRITERIA' => 'VALUE']);
    }

    public function testEntityRepositoryFindByAcceptsArrayOfCriteria()
    {
        $this->query
            ->shouldReceive('getResult')
        ;

        $this->repository->findBy(['CRITERIA' => 'VALUE']);
    }

    public function testEntityRepositoryGetAliasReturnsString()
    {
        $this->assertSame($this->repository->getAlias(), 'o');
    }

    public function testEntityRepositorycreateQueryBuilderReturnsInstanceofQueryBuilder()
    {
        $this->assertInstanceOf('\Accard\Bundle\ResourceBundle\Doctrine\ORM\QueryBuilder', $this->repository->createQueryBuilder('o'));
    }

    public function testEntityRepositorygetQueryBuilderReturnsInstanceOfQueryBuilder()
    {
        $this->assertInstanceOf('\Accard\Bundle\ResourceBundle\Doctrine\ORM\QueryBuilder', $this->repository->createQueryBuilder('o'));
    }

    public function testEntityRepositoryGetCollectionQueryBuilderReturnsInstanceofQueryBuilder()
    {
        $this->assertInstanceOf('\Accard\Bundle\ResourceBundle\Doctrine\ORM\QueryBuilder', $this->repository->getCollectionQueryBuilder());
    }

    public function testEntityRepositoryGetCountShouldReturnSingleScalarResult()
    {
        $this->query
            ->shouldReceive('getSingleScalarResult')
        ;
        $this->repository->getCount();
    }

    public function testEntityRepositoryCreatePaginatorDoesNotNeedAnyArguments()
    {
        $this->repository->createPaginator();
    }

    public function testEntityRepositoryCreatePaginatorAcceptsCriteria()
    {
        $this->repository->createPaginator(['TEST' => 'CRITERIA']);
    }

    public function testEntityRepositoryCreatePaginatorAcceptsCriteriaAndOrderingBy()
    {
        $this->repository->createPaginator(['TEST' => 'CRITERIA'], ['ORDER_BY' => 'TESTING']);
    }

    public function testEntityRepositoryCreatePaginatorReturnsPagerfantaInstance()
    {
        $this->assertInstanceOf(
            'Pagerfanta\Pagerfanta',
            $this->repository->createPaginator()
        );
    }

    public function testEntityRepositoryGetPaginatorReturnsPagerfanta()
    {
        $queryBuilder = Mockery::mock('Accard\Bundle\ResourceBundle\Doctrine\ORM\QueryBuilder');
        $queryBuilder->shouldReceive('getQuery');

        $this->assertInstanceOf(
            'Pagerfanta\Pagerfanta',
            $this->repository->getPaginator($queryBuilder)
        );
    }
}