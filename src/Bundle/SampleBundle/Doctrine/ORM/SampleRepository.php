<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SampleBundle\Doctrine\ORM;

use Accard\Component\Sample\Repository\SampleRepositoryInterface;
use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic sample repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SampleRepository extends EntityRepository implements SampleRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'sample';
    }
}
