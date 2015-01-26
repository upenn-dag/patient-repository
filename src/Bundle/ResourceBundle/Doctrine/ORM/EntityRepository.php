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

use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Accard\Component\Resource\Repository\RepositoryInterface;

/**
 * Doctrine ORM driver entity repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class EntityRepository extends BaseEntityRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        $className = $this->getClassName();

        return new $className;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this
            ->getQueryBuilder()
            ->andWhere($this->getAlias().'.id = '.intval($id))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this
            ->getCollectionQueryBuilder()
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria)
    {
        $queryBuilder = $this->getQueryBuilder();

        $this->applyCriteria($queryBuilder, $criteria);

        return $queryBuilder->getQuery()->getOneOrNullResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $queryBuilder = $this->getCollectionQueryBuilder();

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);

        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }

        if (null !== $offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'o';
    }

    /**
     * Get query builder class.
     *
     * Returns the FQCN of the query builder class used by this repository. This
     * will allow us to override the query builder in extending repositories.
     *
     * @return string
     */
    protected function getQueryBuilderClass()
    {
        return '\Accard\Bundle\ResourceBundle\Doctrine\ORM\QueryBuilder';
    }

    /**
     * {@inheritdoc}
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        $queryBuilderClass = $this->getQueryBuilderClass();
        $queryBuilder = new $queryBuilderClass($this->getEntityManager(), $this);

        return $queryBuilder
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy);
    }

    /**
     * Get query builder.
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    /**
     * Get collection query builder.
     *
     * @return QueryBuilder
     */
    public function getCollectionQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        $countString = sprintf('COUNT(%s.id)', $this->getAlias());

        return $this->getQueryBuilder()->select($countString)->getQuery()->getSingleScalarResult();
    }

    /**
     * Create paginator for given criteria.
     *
     * @param array|null $criteria
     * @param array|null $sorting
     * @return PagerfantaInterface
     */
    public function createPaginator(array $criteria = null, array $orderBy = null)
    {
        $queryBuilder = $this->getCollectionQueryBuilder();

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }

    /**
     * Get paginator for a query builder.
     *
     * @param QueryBuilder $queryBuilder
     * @return PagerfantaInterface
     */
    public function getPaginator(QueryBuilder $queryBuilder)
    {
        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
    }

    /**
     * Merge criteria array into query builder.
     *
     * @param QueryBuilder $queryBuilder
     * @param array|null $criteria
     * @param boolean $strict
     */
    protected function applyCriteria(QueryBuilder $queryBuilder, array $criteria = null, $strict = false)
    {
        if (null === $criteria) {
            return;
        }

        foreach ($criteria as $property => $value) {
            $queryBuilder->filterByColumn($property, $value, $strict);
        }
    }

    /**
     * Merge sorting array into query builder.
     *
     * @param QueryBuilder $queryBuilder
     * @param array $sorting
     */
    protected function applySorting(QueryBuilder $queryBuilder, array $sorting = null)
    {
        if (null === $sorting) {
            return;
        }

        foreach ($sorting as $property => $order) {
            if (!empty($order)) {
                $queryBuilder->orderBy($this->getPropertyName($property), $order);
            }
        }
    }

    /**
     * Get fully qualified property name.
     *
     * @param string $name
     * @return string
     */
    protected function getPropertyName($name)
    {
        if (false === strpos($name, '.')) {
            return $this->getAlias().'.'.$name;
        }

        return $name;
    }
}
