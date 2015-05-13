<?php
namespace AccardTest\Bundle\ResourceBundle\EventListener;

/**
 * Oracle Session Init Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\EventListener\OracleSessionInit;
use Mockery;

class OracleSessionInitTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->args = Mockery::mock('Doctrine\DBAL\Event\ConnectionEventArgs');

        $this->oracleSession = new OracleSessionInit();
    }

    public function testOracleSessionInitShouldRejectNonOracleDatabasePlatforms()
    {
        $this->args->shouldReceive('getDatabasePlatform')->once()->andReturn('NOT_A_ORACLE_PLATFORM');

        $this->assertEmpty($this->oracleSession->postConnect($this->args));
    }

    public function testOracleSessionInitShouldAcceptOracleDatabasePlatorms()
    {
        $oracleDbPlatform = Mockery::mock('Doctrine\DBAL\Platforms\OraclePlatform');
        $mock = Mockery::mock()
            ->shouldReceive('executeUpdate')
            ->getMock()
        ;

        $this->args
            ->shouldReceive('getDatabasePlatform')->once()->andReturn($oracleDbPlatform)
            ->shouldReceive('getConnection')->andReturn($mock)
        ;

        $this->assertEmpty($this->oracleSession->postConnect($this->args));
    }

}