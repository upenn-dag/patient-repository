<?php
namespace AccardTest\Bundle\ResourceBundle\Search;

/**
 * Search Collection Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Search\SearchCollection;
use Mockery;

class SearchCollectionTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->query = Mockery::mock('Elastica\Query\AbstractQuery')
            ->shouldReceive('getParam')->with('query')->andReturn('QUERY')
            ->getMock()
        ;

        $this->results = array();

        $this->searchCollection = new SearchCollection($this->query, $this->results);
    }

    public function testSearchCollectionImplementsCountable()
    {
        $this->assertInstanceOf(
            'Countable',
            $this->searchCollection
        );
    }

    public function testSearchCollectionImplementsIteratorAggregate()
    {
        $this->assertInstanceOf(
            'IteratorAggregate',
            $this->searchCollection
        );
    }

    public function testSearchCollectionCanRetrieveQuery()
    {
        $this->assertSame($this->query, $this->searchCollection->getQuery());
    }

    public function testSearchColletionCanRetrieveText()
    {
        $this->assertEquals('QUERY', $this->searchCollection->getText());
    }

    public function testSearchCollectionAddsToResults()
    {
        $result = Mockery::mock('FOS\ElasticaBundle\HybridResult')
            ->shouldReceive('getResult')->andReturn('RESULT')
            ->shouldReceive('getTransformed')->andReturn('TRANSFORMED')
            ->getMock()
        ;

        $this->searchCollection->add($result);

        $this->assertEquals(1, $this->searchCollection->count());
    }

    public function testSearchCollectionGetIterator()
    {
        $iterator = $this->searchCollection->getIterator();

        $this->assertInstanceOf('ArrayIterator', $iterator);
    }

    public function testSearchCollectionGetPatients()
    {
        $patientResult = Mockery::mock()
            ->shouldReceive('getType')->andReturn('patient')
            ->getMock()
        ;

        $result = Mockery::mock('FOS\ElasticaBundle\HybridResult')
            ->shouldReceive('getResult')->andReturn($patientResult)
            ->shouldReceive('getTransformed')->andReturn('TRANSFORMED')
            ->getMock()
        ;

        $this->searchCollection->add($result);

        $this->assertEquals(1, count($this->searchCollection->getPatients()));
    }

    public function testSearchCollectionGetPatientsReturns0IfNoPatientsPresent()
    {
        $this->assertEquals(0, count($this->searchCollection->getPatients()));
    }

    public function testSearchCollectionGetDiagnoses()
    {
        $patientResult = Mockery::mock()
            ->shouldReceive('getType')->andReturn('diagnosis')
            ->getMock()
        ;

        $result = Mockery::mock('FOS\ElasticaBundle\HybridResult')
            ->shouldReceive('getResult')->andReturn($patientResult)
            ->shouldReceive('getTransformed')->andReturn('TRANSFORMED')
            ->getMock()
        ;

        $this->searchCollection->add($result);

        $this->assertEquals(1, count($this->searchCollection->getDiagnoses()));
    }

    public function testSearchCollectionGetDiagnosesReturns0IfNoDiagnosisPresent()
    {
        $this->assertEquals(0, count($this->searchCollection->getDiagnoses()));
    }

    public function testSearchCollectionAddsResultsToSelf()
    {
        $query = Mockery::mock('Elastica\Query\AbstractQuery')
            ->shouldReceive('getParam')->with('query')->andReturn('QUERY')
            ->getMock()
        ;

        $one = Mockery::mock('FOS\ElasticaBundle\HybridResult')
            ->shouldReceive('getResult')->andReturn('result')
            ->shouldReceive('getTransformed')->andReturn('TRANSFORMED')
            ->getMock()
        ;

        $two = Mockery::mock('FOS\ElasticaBundle\HybridResult')
            ->shouldReceive('getResult')->andReturn('result')
            ->shouldReceive('getTransformed')->andReturn('TRANSFORMED')
            ->getMock()
        ;

        $three = Mockery::mock('FOS\ElasticaBundle\HybridResult')
            ->shouldReceive('getResult')->andReturn('result')
            ->shouldReceive('getTransformed')->andReturn('TRANSFORMED')
            ->getMock()
        ;

        $results = array($one, $two, $three);

        $searchCollection = new SearchCollection($query, $results);

        $this->assertEquals(count($results), $searchCollection->count());
    }
}