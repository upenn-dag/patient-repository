<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Medication repository
 */
class MedicationRepository extends EntityRepository
{
    public function getCytarabineTestResults()
    {
        $query = <<<DQL
SELECT M,MO,O,R 
FROM   Accard\Bundle\PDSBundle\Entity\Medication M 
JOIN   M.medicationOrders MO 
JOIN   MO.order O 
JOIN   O.orderResults R 
WHERE  UPPER(M.fullName) = 'CYTARABINE'
AND    R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }

    public function getClofarabineTestResults()
    {
        $query = <<<DQL
SELECT M,MO,O,R 
FROM   Accard\Bundle\PDSBundle\Entity\Medication M 
JOIN   M.medicationOrders MO 
JOIN   MO.order O 
JOIN   O.orderResults R 
WHERE  UPPER(M.fullName) = 'CLOFARABINE'
AND    R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }

   public function getAzacytidineTestResults()
    {
        $query = <<<DQL
SELECT M,MO,O,R 
FROM   Accard\Bundle\PDSBundle\Entity\Medication M 
JOIN   M.medicationOrders MO 
JOIN   MO.order O 
JOIN   O.orderResults R 
WHERE  UPPER(M.fullName) = 'AZACYTIDINE'
AND    R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }

   public function getDecitabineTestResults()
    {
        $query = <<<DQL
SELECT M,MO,O,R 
FROM   Accard\Bundle\PDSBundle\Entity\Medication M 
JOIN   M.medicationOrders MO 
JOIN   MO.order O 
JOIN   O.orderResults R 
WHERE  UPPER(M.fullName) = 'DECITABINE'
AND    R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }

   public function getIdarubicinTestResults()
    {
        $query = <<<DQL
SELECT M,MO,O,R 
FROM   Accard\Bundle\PDSBundle\Entity\Medication M 
JOIN   M.medicationOrders MO 
JOIN   MO.order O 
JOIN   O.orderResults R 
WHERE  UPPER(M.fullName) = 'IDARUBICIN'
AND    R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }

   public function getHydroxyureaTestResults()
    {
        $query = <<<DQL
SELECT M,MO,O,R 
FROM   Accard\Bundle\PDSBundle\Entity\Medication M 
JOIN   M.medicationOrders MO 
JOIN   MO.order O 
JOIN   O.orderResults R 
WHERE  (UPPER(M.fullName) = 'HYDROXYUREA' OR UPPER(M.fullName) = 'HYDROXYCARBAMIDE') 
AND    R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }
}