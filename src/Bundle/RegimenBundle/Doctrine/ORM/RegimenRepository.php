<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\RegimenBundle\Doctrine\ORM;

use Accard\Component\Regimen\Repository\RegimenRepositoryInterface;
use DAG\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic regimen repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenRepository extends EntityRepository implements RegimenRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'regimen';
    }
}
