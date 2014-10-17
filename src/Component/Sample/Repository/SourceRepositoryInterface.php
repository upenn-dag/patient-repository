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

use Accard\Component\Resource\Repository\RepositoryInterface;
use Accard\Component\Sample\Model\SourceInterface;

/**
 * Sample source repository interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SourceRepositoryInterface extends RepositoryInterface
{
    /**
     * Get collection sources.
     *
     * @param array $criteria
     * @param array $sorting
     * @return SourceInterface[]
     */
    public function getCollections(array $criteria = null, array $sorting = null);

    /**
     * Get derivative sources.
     *
     * @param array $criteria
     * @param array $sorting
     * @return SourceInterface[]
     */
    public function getDerivatives(array $criteria = null, array $sorting = null);
}
