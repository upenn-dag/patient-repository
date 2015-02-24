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

use Accard\Component\Patient\Utils;
use PagerFanta\PagerfantaInterface;
use Accard\Component\Patient\Model\PatientInterface;
use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Accard\Component\Patient\Repository\PatientRepositoryInterface;

/**
 * Basic patient repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientRepository extends EntityRepository implements PatientRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getByName($patientName)
    {
        $name = Utils::parseName($patientName);
        $criteria = array('firstName' => $name['forename']);

        if (!empty($name['surname'])) {
            $criteria['lastName'] = $name['surname'];
        }

        return $this->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'patient';
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
        $queryBuilder = $this->getQueryBuilder();

        if (!is_array($criteria)) {
            $criteria = array();
        }

        if (!is_array($sorting)) {
            $sorting = array();
        }

        if (!empty($criteria['firstName'])) {

            //remove % just in case if user inputs it
            $criteria['firstName'] = str_replace('%', '',  $criteria['firstName']);
            $criteria['firstName'] = "%" . $criteria['firstName'] . "%";

             $queryBuilder
                ->andWhere('LOWER(patient.firstName) LIKE :firstName')
                ->setParameter('firstName', strtolower($criteria['firstName']));

            unset($criteria['firstName']);
        }


        if (!empty($criteria['lastName'])) {
          
             //remove % just in case if user inputs it
            $criteria['lastName'] = str_replace('%', '',  $criteria['lastName']);
            $criteria['lastName'] = "%" . $criteria['lastName'] . "%";

            $queryBuilder
                 ->andWhere('LOWER(patient.lastName) LIKE :lastName')
                ->setParameter('lastName', strtolower($criteria['lastName']));

            unset($criteria['lastName']);
        }

        if (!empty($criteria['phase'])) {
            $queryBuilder
                ->join('patient.phases', 'phase_instance')
                ->join('phase_instance.phase', 'phase')
                ->filterByColumn('phase.id', (int) $criteria['phase'])
                ->filterByColumn('phase_instance.endDate', null)
            ;
        }

        if (!empty($criteria['deceased'])) {
            $queryBuilder->filterByStatement('patient.dateOfDeath IS NOT NULL');
        }


        unset($criteria['phase'], $criteria['deceased']);
        $this->applyCriteria($queryBuilder, $criteria);
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
