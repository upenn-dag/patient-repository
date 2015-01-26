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
    private $elasticaResult;
    private $transformedResult;

    public function __construct(HybridResult $result)
    {
        $this->elasticaResult = $result->getResult();
        $this->transformedResult = $result->getTransformed();
    }

    public function getId()
    {
        return $this->elasticaResult->getId();
    }

    public function getIndex()
    {
        return $this->elasticaResult->getIndex();
    }

    public function getScore()
    {
        return $this->elasticaResult->getScore();
    }

    public function getPercentage()
    {
        return round($this->elasticaResult->getScore() * 100, 2, PHP_ROUND_HALF_UP);
    }

    public function getType()
    {
        return $this->elasticaResult->getType();
    }

    public function getRawData()
    {
        return $this->elasticaResult->getData();
    }

    public function getData()
    {
        return $this->transformedResult;
    }
}
