<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ActivityBundle\Doctrine\ORM;

use Accard\Component\Activity\Repository\ActivityRepositoryInterface;
use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic activity repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityRepository extends EntityRepository implements ActivityRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'activity';
    }
}
