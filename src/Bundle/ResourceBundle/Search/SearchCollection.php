<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Search;

use Countable;
use IteratorAggregate;
use ArrayIterator;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\ElasticaBundle\HybridResult;
use Elastica\Query\AbstractQuery;

/**
 * Search collection.
 *
 * Adds functionality around an array of search results from Elasticsearch.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SearchCollection implements Countable, IteratorAggregate
{
    /**
     * Query.
     *
     * @var AbstractQuery
     */
    private $query;

    /**
     * Results.
     *
     * @var array
     */
    private $results = array();


    /**
     * Constructor.
     *
     * @param AbstractQuery $query
     * @param array $results
     */
    public function __construct(AbstractQuery $query, array $results = array())
    {
        $this->query = new Query($query);
        foreach ($results as $result) {
            $this->add($result);
        }
    }

    /**
     * Get query.
     *
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query->getQuery();
    }

    /**
     * Get query text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->query->getText();
    }

    /**
     * Add result.
     *
     * Converts a result into an Accard search result locally before it is
     * added to the collection.
     *
     * @param HybridResult $result
     * @return self
     */
    public function add(HybridResult $result)
    {
        $hash = spl_object_hash($result);
        $result = new SearchResult($result);
        $this->results[$hash] = $result;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->results);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->results);
    }

    // Helper methods?

    /**
     * Get patient results.
     *
     * @return array
     */
    public function getPatients()
    {
        return array_filter($this->results, function($v) { return 'patient' === $v->getType(); });
    }

    /**
     * Get diagnosis results.
     *
     * @return array
     */
    public function getDiagnoses()
    {
        return array_filter($this->results, function($v) { return 'diagnosis' === $v->getType(); });
    }
}
