<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Model repository interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface RepositoryInterface extends ObjectRepository
{
    /**
     * Create a new resource
     *
     * @return mixed
     */
    public function createNew();

    /**
     * Get paginated collection
     *
     * @param array $criteria
     * @param array $orderBy
     *
     * @return mixed
     */
    public function createPaginator(array $criteria = null, array $orderBy = null);
}
