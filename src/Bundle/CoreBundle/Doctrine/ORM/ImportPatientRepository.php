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

use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Accard\Component\Resource\Model\ImportTargetInterface;

/**
 * Accard import patient repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportPatientRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function createActivePaginator(array $criteria = null, array $orderBy = null)
    {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->where('import_patient.status = :status');
        $queryBuilder->setParameter('status', ImportTargetInterface::ACTIVE);

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'import_patient';
    }
}
