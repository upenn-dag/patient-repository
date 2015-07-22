<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Sample\Repository;

use PagerFanta\PagerfantaInterface;
use Doctrine\ORM\QueryBuilder;
use DAG\Component\Resource\Repository\RepositoryInterface;
use Accard\Component\Sample\Model\SourceInterface;

/**
 * Sample source repository interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SourceRepositoryInterface extends RepositoryInterface
{
    /**
     * Get collection sources query builder.
     *
     * @param array $criteria
     * @param array $sorting
     * @return QueryBuilder
     */
    public function createCollectionQueryBuilder(array $criteria = array(), array $sorting = array());

    /**
     * Get collection sources paginator.
     *
     * @param array $criteria
     * @param array $sorting
     * @return PagerfantaInterface
     */
    public function createCollectionPaginator(array $criteria = array(), array $sorting = array());

    /**
     * Get derivative sources query builder.
     *
     * @param array $criteria
     * @param array $sorting
     * @return QueryBuilder
     */
    public function createDerivationQueryBuilder(array $criteria = array(), array $sorting = array());

    /**
     * Get derivation sources paginator.
     *
     * @param array $criteria
     * @param array $sorting
     * @return PagerfantaInterface
     */
    public function createDerivationPaginator(array $criteria = array(), array $sorting = array());
}
