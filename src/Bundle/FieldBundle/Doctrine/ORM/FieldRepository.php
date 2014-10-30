<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FieldBundle\Doctrine\ORM;

use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Accard\Component\Field\Repository\FieldRepositoryInterface;

/**
 * Field repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldRepository extends EntityRepository implements FieldRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'field';
    }
}
