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

use Accard\Component\Phase\Repository\PhaseRepositoryInterface;
use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic phase repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PhaseRepository extends EntityRepository implements PhaseRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'phase';
    }
}
