<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PhaseBundle\Doctrine\ORM;

use Accard\Component\Phase\Repository\PhaseInstanceRepositoryInterface;
use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic phase instance repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class AbstractPhaseInstanceRepository extends EntityRepository implements PhaseInstanceRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'phase_instance';
    }

    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        return $this->getQueryBuilder()->select('COUNT(phase_instance.target)')->getQuery()->getSingleScalarResult();
    }
}
