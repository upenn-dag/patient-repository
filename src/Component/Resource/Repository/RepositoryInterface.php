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

use Pagerfanta\PagerfantaInterface;
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
     * Get entity count.
     *
     * @return integer
     */
    public function getCount();

    /**
     * Get entity alias for use in DQL.
     *
     * @return string
     */
    public function getAlias();
}
