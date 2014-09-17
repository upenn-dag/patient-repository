<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Repository;

use Accard\Component\Resource\Repository\RepositoryInterface;
use Pagerfanta\PagerfantaInterface;

/**
 * Import repository interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ImportRepositoryInterface extends RepositoryInterface
{
    /**
     * Get most recent record for a given importer.
     *
     * @param string $importer
     * @return ImportInterface
     */
    public function getMostRecentFor($importer);
}
