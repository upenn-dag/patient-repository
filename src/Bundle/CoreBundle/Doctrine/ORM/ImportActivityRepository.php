<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Doctrine\ORM;

use DAG\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use DAG\Component\Resource\Model\ImportTargetInterface;

/**
 * Accard import activity repository.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class ImportActivityRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function createActivePaginator(array $criteria = null, array $orderBy = null)
    {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->where('import_activity.status = :status');
        $queryBuilder->setParameter('status', ImportTargetInterface::ACTIVE);

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'import_activity';
    }
}
