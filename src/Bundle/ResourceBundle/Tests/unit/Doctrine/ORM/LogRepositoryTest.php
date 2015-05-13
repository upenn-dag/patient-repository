<?php
namespace AccardTest\Bundle\ResourceBundle\Doctrine\ORM;

/**
 * Log Repository Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Doctrine\ORM\LogRepository;
use Accard\Bundle\ResourceBundle\Test\RepositoryTestCase;
use Mockery;

class LogRepositoryTest extends RepositoryTestCase
{
    protected function _before()
    {
        $this->repository = new LogRepository($this->em, $this->class);
    }

    public function testLogRepositoryGetAliasReturnsCorrectString()
    {
        $this->assertSame($this->repository->getAlias(), 'log');
    }

    public function testLogRepositoryGetUserLogBuilderAcceptsUserInterface()
    {
        $user = Mockery::mock('Accard\Component\Resource\Model\UserInterface');

        $this->repository->getUserLogBuilder($user);
    }

    public function testLogRepositoryGetUserLogBuilderReturnsQueryBuilder()
    {
        $user = Mockery::mock('Accard\Component\Resource\Model\UserInterface');

        $this->assertInstanceOf(
            'Accard\Bundle\ResourceBundle\Doctrine\ORM\QueryBuilder',
            $this->repository->getUserLogBuilder($user)
        ); 
    }
}