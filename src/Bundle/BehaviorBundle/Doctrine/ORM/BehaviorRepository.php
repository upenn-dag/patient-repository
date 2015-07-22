<?php
/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\BehaviorBundle\Doctrine\ORM;

use DAG\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic behavior repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class BehaviorRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'behavior';
    }

    /**
     * Get behavior count.
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->getQueryBuilder()->select('COUNT(behavior.id)')->getQuery()->getSingleScalarResult();
    }

}
