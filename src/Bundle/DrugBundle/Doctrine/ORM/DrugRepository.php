<?php
/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DrugBundle\Doctrine\ORM;

use Accard\Component\Drug\Repository\DrugRepositoryInterface;
use DAG\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic drug repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DrugRepository extends EntityRepository implements DrugRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'drug';
    }
}
