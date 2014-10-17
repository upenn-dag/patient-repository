<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Diagnosis Code repository
 */
class DiagnosisCodeRepository extends EntityRepository
{
    public function getAMLResults()
    {
        $query = <<<DQL
SELECT DC, D, E, O, R
FROM   Accard\Bundle\PDSBundle\Entity\DiagnosisCode DC
       JOIN DC.diagnoses D
       JOIN D.encounter E
       JOIN E.orders O
       JOIN O.orderResults R
WHERE  DC.code IN ('205.0', '205.00', '205.01', '205.02')
       AND R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);

        return $q->getResult();
    }
}
