<?php
namespace AccardTest\Bundle\ResourceBundle\Doctrine\ORM;

/**
 * Import Repository Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Test\RepositoryTestCase;
use Accard\Bundle\ResourceBundle\Doctrine\ORM\ImportRepository;

class ImportRepositoryTest extends RepositoryTestCase
{
    protected function _before()
    {
        $this->repository = new ImportRepository($this->em, $this->class);
    }

    public function testImportRepositoryAdheresToImportRepositoryInterface()
    {
        $this->assertInstanceOf(
            'Accard\Bundle\ResourceBundle\Repository\ImportRepositoryInterface', 
            $this->repository
        );
    }

    public function testImportRepositoryGetAliasReturnsCorrectString()
    {
        $this->assertSame('import', $this->repository->getAlias());
    }

    public function testImportRepositoryGetAllForReturnsResultsFromQuery()
    {
        $this->query->shouldReceive('getResult')
            ->once()
            ->andReturn('TEST')
        ;

        $this->assertSame('TEST', $this->repository->getAllFor('TEST'));
    }

    public function testImportRepositoryGetCountForShouldCallGetSingleScalarResult()
    {
        $this->query->shouldReceive('getSingleScalarResult')->andReturn('RESULT');
        $this->assertSame('RESULT', $this->repository->getCountFor('TEST'));
    }

    public function testImportRepositoryGetLatestForShouldReturnGetOneOrNullResult()
    {
        $this->query->shouldReceive('getOneOrNullResult')->once()->andReturn('RESULT');

        $this->assertSame('RESULT', $this->repository->getLatestFor('TEST'));
    }

    public function testImportRegistryGetMostRecentForShouldReturnGetOneOrNullResult()
    {
        $this->query->shouldReceive('getOneOrNullResult')->once()->andReturn('RESULT');

        $this->assertSame('RESULT', $this->repository->getMostRecentFor('TEST'));
    }
}