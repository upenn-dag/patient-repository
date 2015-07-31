<?php
/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\AttributeBundle\Doctrine\ORM;

use DAG\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic attribute repository.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class AttributeRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'attribute';
    }

    /**
     * Get attribute count.
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->getQueryBuilder()->select('COUNT(attribute.id)')->getQuery()->getSingleScalarResult();
    }
}
