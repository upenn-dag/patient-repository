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

/**
 * Query object.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Query
{
    private $rawQuery;
    private $queryText;

    /**
     * Constructor.
     *
     * @param mixed $query
     */
    public function __construct($query)
    {
        $this->rawQuery = $query;
        $this->queryText = $query->getParam('query');
    }

    /**
     * Get query.
     *
     * @return mixed
     */
    public function getQuery()
    {
        return $this->rawQuery;
    }

    /**
     * Get query text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->queryText;
    }
}
