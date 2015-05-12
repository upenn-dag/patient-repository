<?php
namespace AccardTest\Bundle\ResourceBundle\Search;

/**
 * Search Result Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Search\SearchResult;
use Mockery;

class SearchResultTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->rawResult = Mockery::mock();
        $this->transformed = Mockery::mock();

        $this->result = Mockery::mock('FOS\ElasticaBundle\HybridResult')
            ->shouldReceive('getResult')->andReturn($this->rawResult)
            ->shouldReceive('getTransformed')->andReturn($this->transformed)
            ->getMocked()
        ;

        $this->searchResult = new SearchResult($this->result);
    }

    // tests
    public function testSearchResultGetId()
    {
        $id = 1;

        $this->rawResult->shouldReceive('getId')->andReturn($id);

        $this->assertEquals($id, $this->searchResult->getId());
    }

}