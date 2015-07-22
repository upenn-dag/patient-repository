<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SampleBundle\Doctrine\ORM;

use PagerFanta\Pagerfanta;
use Accard\Component\Sample\Repository\SourceRepositoryInterface;
use DAG\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic sample repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SourceRepository extends EntityRepository implements SourceRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createCollectionQueryBuilder(array $criteria = array(), array $sorting = array())
    {
        $qb = $this
            ->getCollectionQueryBuilder()
            ->andWhere('source.sample IS NULL');

        $this->applyCriteria($qb, $criteria);
        $this->applySorting($qb, $sorting);

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function createCollectionPaginator(array $criteria = array(), array $sorting = array())
    {
        return $this->getPaginator($this->createCollectionQueryBuilder($criteria, $sorting));
    }

    /**
     * {@inheritdoc}
     */
    public function createDerivationQueryBuilder(array $criteria = array(), array $sorting = array())
    {
        $qb = $this
            ->getCollectionQueryBuilder()
            ->andWhere('source.sample IS NOT NULL');

        $this->applyCriteria($qb, $criteria);
        $this->applySorting($qb, $sorting);

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function createDerivationPaginator(array $criteria = array(), array $sorting = array())
    {
        return $this->getPaginator($this->createDerivationQueryBuilder($criteria, $sorting));
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'source';
    }
}
