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
            ->getMock()
        ;

        $this->searchResult = new SearchResult($this->result);
    }

    // tests
    public function testSearchResultGetIdReturnsId()
    {
        $id = 1;

        $this->rawResult->shouldReceive('getId')->andReturn($id);

        $this->assertEquals($id, $this->searchResult->getId());
    }

    public function testSearchResultGetIndexReturnsIndex()
    {  
        $index = 1;

        $this->rawResult->shouldReceive('getIndex')->andReturn($index);

        $this->assertEquals($index, $this->searchResult->getIndex());
    }

    public function testSearchResultGetTypeReturnsType()
    {
        $score = .5;

        $this->rawResult->shouldReceive('getScore')->andReturn($score);

        $this->assertEquals($score, $this->searchResult->getScore());
    }

    public function getDataRawReturnQuerysData()
    {
        $data = 'DATA';

        $this->rawResult->shouldReceive('getData')->andReturn($data);

        $this->assertEquals($data, $this->searchResult->getRawData());
    }

    public function getDataReturnsTransformer()
    {
        $this->assertSame($this->transformed, $this->searchResult->getData());
    }

    public function testSearchResultsGetPercentageReturnsRoundedResult()
    {
        $score = .5555;

        $this->rawResult->shouldReceive('getScore')->andReturn($score);

        $this->assertEquals(round($score * 100, 2, PHP_ROUND_HALF_UP), $this->searchResult->getPercentage());
    }  
}