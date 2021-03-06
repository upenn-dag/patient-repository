<?php
/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle\Doctrine\ORM;

use Accard\Component\Diagnosis\Model\CodeInterface;
use Accard\Component\Diagnosis\Repository\DiagnosisRepositoryInterface;
use DAG\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic diagnosis repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisRepository extends EntityRepository implements DiagnosisRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'diagnosis';
    }

    /**
     * Get patient count.
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->getQueryBuilder()->select('COUNT(diagnosis.id)')->getQuery()->getSingleScalarResult();
    }

    /**
     * Get ongoing diagnoses query builder.
     *
     * @param array $criteria
     * @param array $sorting
     * @return QueryBuilder
     */
    public function getOngoingDiagnosesQueryBuilder(array $criteria = array(), array $sorting = array())
    {
        $qb = $this->getQueryBuilder()->where('diagnosis.endDate IS NULL');
        $qb->applyCriteria($criteria);
        $qb->applySorting($sorting);

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function getOngoingDiagnoses(array $criteria = array(), array $sorting = array())
    {
        return $this->getOngoingDiagnosesQueryBuilder($criteria, $sorting)->getQuery()->getResult();
    }
}
