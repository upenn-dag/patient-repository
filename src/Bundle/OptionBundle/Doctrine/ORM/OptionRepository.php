<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OptionBundle\Doctrine\ORM;

use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Accard\Component\Option\Repository\OptionRepositoryInterface;

/**
 * Basic option repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionRepository extends EntityRepository implements OptionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'option';
    }

    /**
     * Get option count.
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->getQueryBuilder()->select('COUNT(option.id)')->getQuery()->getSingleScalarResult();
    }
}
