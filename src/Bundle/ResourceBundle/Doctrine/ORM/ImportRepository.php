<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Doctrine\ORM;

use Accard\Bundle\ResourceBundle\Repository\ImportRepositoryInterface;
use Accard\Component\Resource\Model\ImportInterface;

/**
 * Accard import repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportRepository extends EntityRepository implements ImportRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'import';
    }

    /**
     * Get all importer imports.
     *
     * @param string $importerName
     * @return array
     */
    public function getAllFor($importerName)
    {
        return $this->getQueryBuilder()
            ->where('import.importer = :importer')
            ->setParameter('importer', $importerName)
            ->orderBy('import.startTimestamp', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get count of all importer imports.
     *
     * @param string $importerName
     * @return integer
     */
    public function getCountFor($importerName)
    {
        return $this->getQueryBuilder()
            ->select('COUNT(import.id)')
            ->where('import.importer = :importer')
            ->setParameter('importer', $importerName)
            ->orderBy('import.startTimestamp', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get last importer import.
     *
     * @param string $importerName
     * @return array
     */
    public function getLatestFor($importerName)
    {
        return $this->getQueryBuilder()
            ->where('import.importer = :importer')
            ->setParameter('importer', $importerName)
            ->orderBy('import.startTimestamp', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getMostRecentFor($importer)
    {
        return $this->getQueryBuilder()
            ->where('import.importer = :importer')
            ->orderBy('import.startTimestamp', 'DESC')
            ->setParameter('importer', $importer)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
