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
use Accard\Component\Option\Repository\OptionValueRepositoryInterface;

/**
 * Basic option value repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionValueRepository extends EntityRepository implements OptionValueRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'option_value';
    }

    /**
     * Get option count.
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->getQueryBuilder()->select('COUNT(option_value.id)')->getQuery()->getSingleScalarResult();
    }
}
