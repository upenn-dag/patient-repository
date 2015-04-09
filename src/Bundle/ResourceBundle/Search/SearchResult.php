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

use FOS\ElasticaBundle\HybridResult;

/**
 * Accard search result.
 *
 * Functionality wrapping around FOS Elastica search results.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SearchResult
{
    /**
     * Elastica hybrid result.
     *
     * @var HybridResult
     */
    private $elasticaResult;

    /**
     * Transformed search result.
     *
     * @var mixed
     */
    private $transformedResult;


    /**
     * Constructor.
     *
     * @param HybridResult $result
     */
    public function __construct(HybridResult $result)
    {
        $this->elasticaResult = $result->getResult();
        $this->transformedResult = $result->getTransformed();
    }

    /**
     * Get result id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->elasticaResult->getId();
    }

    /**
     * Get result index.
     *
     * @return integer
     */
    public function getIndex()
    {
        return $this->elasticaResult->getIndex();
    }

    /**
     * Get result relevance score.
     *
     * @return float
     */
    public function getScore()
    {
        return $this->elasticaResult->getScore();
    }

    /**
     * Get result relevance percentage.
     *
     * @return float
     */
    public function getPercentage()
    {
        return round($this->elasticaResult->getScore() * 100, 2, PHP_ROUND_HALF_UP);
    }

    /**
     * Get result type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->elasticaResult->getType();
    }

    /**
     * Get result raw data.
     *
     * @return array
     */
    public function getRawData()
    {
        return $this->elasticaResult->getData();
    }

    /**
     * Get transformed result data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->transformedResult;
    }
}
