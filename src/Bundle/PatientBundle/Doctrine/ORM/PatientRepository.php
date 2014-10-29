<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PatientBundle\Doctrine\ORM;

use PagerFanta\PagerfantaInterface;
use Accard\Component\Patient\Model\PatientInterface;
use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic patient repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'patient';
    }

    /**
     * Get patient count.
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->getQueryBuilder()->select('COUNT(patient.id)')->getQuery()->getSingleScalarResult();
    }

    /**
     * Get patient by MRN.
     * 
     * @param string $mrn
     * @return PatientInterface
     */
    public function getByMRN($mrn)
    {
        return $this->findOneBy(array('mrn' => $mrn));
    }

    /**
     * Create filter paginator.
     *
     * @param array   $criteria
     * @param array   $sorting
     *
     * @return PagerfantaInterface
     */
    public function createFilterPaginator(array $criteria = null, array $sorting = null)
    {
        $queryBuilder = parent::getCollectionQueryBuilder()->select('patient');

        if (!is_array($criteria)) {
            $criteria = array();
        }

        if (!empty($criteria['phase'])) {
            $queryBuilder
                ->join('patient.phases', 'phase_instance')
                ->join('phase_instance.phase', 'phase')
                ->andWhere('phase.id = :phaseId')
                ->andWhere('phase_instance.endDate IS NULL')
                ->setParameter('phaseId', (int) $criteria['phase']);
        }

        if (!empty($criteria['mrn'])) {
            $queryBuilder
                ->andWhere('patient.mrn '.$this->getQueryEquality($criteria['mrn']).' :mrn')
                ->setParameter('mrn', $criteria['mrn']);
        }

        if (!empty($criteria['firstName'])) {
            $queryBuilder
                ->andWhere('patient.firstName '.$this->getQueryEquality($criteria['firstName']).' :firstName')
                ->setParameter('firstName', $criteria['firstName']);
        }

        if (!empty($criteria['lastName'])) {
            $queryBuilder
                ->andWhere('patient.lastName '.$this->getQueryEquality($criteria['lastName']).' :lastName')
                ->setParameter('lastName', $criteria['lastName']);
        }

        if (!empty($criteria['deceased'])) {
            $queryBuilder
                ->andWhere('patient.dateOfDeath IS NOT NULL');
        }

        if (!is_array($sorting)) {
            $sorting = array();
        }

        $this->applySorting($queryBuilder, $sorting);

        return $this->getPaginator($queryBuilder);
    }

    private function getQueryEquality($input)
    {
        if (false !== strpos($input, '%')) {
            return 'LIKE';
        }

        return '=';
    }
}
