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
 * Query.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Query
{
    private $rawQuery;
    private $queryText;

    public function __construct($query)
    {
        $this->rawQuery = $query;
        $this->queryText = $query->getParam('query');
    }

    public function getQuery()
    {
        return $this->rawQuery;
    }

    public function getText()
    {
        return $this->queryText;
    }
}
