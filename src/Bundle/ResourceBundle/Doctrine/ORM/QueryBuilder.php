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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;
use Doctrine\ORM\Query;

/**
 * Doctrine ORM extended query builder.
 *
 * Used by default for all entity repositories within Accard. This assumes
 * that they use the Accard entity repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class QueryBuilder extends DoctrineQueryBuilder
{
    /**
     * Entity repository.
     *
     * @var EntityRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param EntityManager $em
     * @param EntityRepository $repository
     */
    public function __construct(EntityManager $em, EntityRepository $repository)
    {
        parent::__construct($em);
        $this->setRepository($repository);
    }

    /**
     * Set entity repository.
     *
     * @param EntityRepository $repository
     */
    public function setRepository(EntityRepository $repository)
    {
        $this->repository = $repository;
        $this->useRepositoryEntity();
    }

    /**
     * Get entity repository.
     *
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Get related entity class name
     *
     * @return string
     */
    protected function getEntityClassName()
    {
        return $this->getRepository()->getClassName();
    }

    /**
     * Configure query builder to use repository entity.
     */
    protected function useRepositoryEntity()
    {
        $this->select($this->repository->getAlias());
        $this->from($this->getEntityClassName(), $this->repository->getAlias());
    }

    /**
     * Apply filter by column
     *
     * Example:
     *   $queryBuilder->filterByColumn('Post.title', 'Superman');
     *   $queryBuilder->filterByColumn('Post.title', 'Super%');
     *   $queryBuilder->filterByColumn('Post.categoryId', array(1,2,3));
     *   $queryBuilder->filterByColumn('Post.subtitle', null);
     *
     * @param string $columnName
     * @param mixed $value
     * @param bool $strict
     * @return QueryBuilder
     */
    public function filterByColumn($columnName, $value, $strict = true)
    {
        if ((null === $value && !$strict) || ('' === $value && !$strict)) {
            return $this;
        }

        // Register full column name if required.
        $fullColumnName = false === strpos($columnName, '.') ? $this->repository->getAlias().'.'.$columnName : $columnName;

        if (is_array($value) || $value instanceof \Iterator) {
            return $this->filterByStatement($this->expr()->in($fullColumnName, $value));
        }

        if ($value === null) {
            return $this->filterByStatement($this->expr()->isNull($fullColumnName));
        }

        $equalityOperator = $this->assertWildcard($value) ? 'LIKE' : '=';
        $parameterName = $this->findUnusedParameterName($columnName);
        $statement = sprintf('%s %s :%s', $fullColumnName, $equalityOperator, $parameterName);

        return $this->filterByStatement($statement, array($parameterName => $value));
    }

    /**
     * Test if value contains a wildcard.
     *
     * @param mixed $value
     * @return boolean
     */
    private function assertWildcard($value)
    {
        return is_string($value) && false !== strpos($value, '%') && false === strpos($value, '\%');
    }

    /**
     * Apply statement filter
     *
     * Example:
     *   $queryBuilder->filterByStatement('Post.title = :title', ['title' => 'Superman']);
     *
     * @param string $statement
     * @param array $parameters
     * @return QueryBuilder
     */
    public function filterByStatement($statement, $parameters = array())
    {
        $this->andWhere($statement);
        $this->appendParameters($parameters);

        return $this;
    }

    /**
     * Limit max number of results
     *
     * @param integer $maxResults
     * @param integer|null $offset
     * @return QueryBuilder
     */
    public function limit($maxResults, $offset = null)
    {
        $this->setMaxResults($maxResults);
        if ($offset !== null) {
            $this->setFirstResult($offset);
        }

        return $this;
    }

    /**
     * Add parameters array to query builder.
     *
     * @param array $parameters
     * @return QueryBuilder
     */
    public function appendParameters($parameters)
    {
        if (is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                $this->setParameter($key, $value);
            }
        }

        return $this;
    }

    /**
     * Fetch all entities.
     *
     * @param array $parameters
     * @return array
     */
    public function fetchAll($parameters = array())
    {
        $this->appendParameters($parameters);

        return $this->getQuery()->getResult();
    }

    /*
     * Fetch first entity
     *
     * @param array $parameters
     * @return array
     */
    public function fetchOne($parameters = array())
    {
        $this->appendParameters($parameters);
        $this->limit(1, 0);

        return $this->getQuery()->getOneOrNullResult();
    }

    /**
     * Fetch first column of first result row
     *
     * @param array $parameters
     * @return mixed
     */
    public function fetchScalar($parameters = array())
    {
        $this->appendParameters($parameters);
        $this->limit(1, 0);
        $result = $this->getQuery()->getSingleResult();

        return is_array($result) ? array_shift($result) : $result;
    }

    /**
     * Find unused parameter name
     *
     * @param string|null $property
     * @return string
     */
    protected function findUnusedParameterName($property = null)
    {
        if (!$property) {
            return 'p' . (count($this->getParameters()) + 1);
        }

        if (false !== ($pos = strpos($property, '.'))) {
            $property = substr($property, $pos + 1);
        }

        return $property;
    }
}
