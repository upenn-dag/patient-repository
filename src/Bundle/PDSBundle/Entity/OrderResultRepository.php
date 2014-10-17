<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Order Result repository
 */
class OrderResultRepository extends EntityRepository
{
    public function getCD13TestResults()
    {
        $query = <<<DQL
SELECT R
FROM   Accard\Bundle\PDSBundle\Entity\OrderResult R JOIN R.resultItem I
WHERE  I.itemCode LIKE 'CD13 %'
       AND R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }

    public function getCD33TestResults()
    {
        $query = <<<DQL
SELECT R
FROM   Accard\Bundle\PDSBundle\Entity\OrderResult R JOIN R.resultItem I
WHERE  I.itemCode LIKE 'CD33 %'
       AND R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }

    public function getLTXTestResults()
    {
        $query = <<<DQL
SELECT R
FROM   Accard\Bundle\PDSBundle\Entity\OrderResult R JOIN R.resultItem I
WHERE  I.itemCode LIKE 'LTX %'
       AND R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }

    public function getFLT3TestResults()
    {
        $query = <<<DQL
SELECT R
FROM   Accard\Bundle\PDSBundle\Entity\OrderResult R JOIN R.resultItem I
WHERE  I.itemCode LIKE 'FLT3 %'
       AND R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }

    public function getNPM1TestResults()
    {
        $query = <<<DQL
SELECT R
FROM   Accard\Bundle\PDSBundle\Entity\OrderResult R JOIN R.resultItem I
WHERE  I.itemCode LIKE 'NPM1 %'
       AND R.resultDate > '2012-01-01'
DQL;
        $q = $this->_em->createQuery($query);
        $q->setMaxResults(250);
        return $q->getResult();
    }
}
