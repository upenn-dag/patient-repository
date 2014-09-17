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

use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic diagnosis repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    protected function getAlias()
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

}
