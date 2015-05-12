<?php
namespace AccardTest\Bundle\ResourceBundle\Search;

/**
 * Query Test
 * 
 * @author Dylan Pierce <me@dylanjpierce.com>
 */
use Accard\Bundle\ResourceBundle\Search\Query;
use Mockery;

class QueryTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->rawQuery = Mockery::mock()
            ->shouldReceive('getParam')->with('query')->andReturn('QUERY')
            ->getMock()
        ;

        $this->query = new Query($this->rawQuery);
    }

    public function testQueryCanRetrieveText()
    {
        $this->assertEquals('QUERY', $this->query->getText());
    }

    public function testQueryCanRetrieveQuery()
    {
        $this->assertSame($this->rawQuery, $this->query->getQuery());
    }
}