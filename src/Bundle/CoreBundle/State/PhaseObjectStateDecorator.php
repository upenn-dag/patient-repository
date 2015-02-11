<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\State;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;

/**
 * Phase object state decorator.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PhaseObjectStateDecorator extends ObjectStateDecorator
{
    /**
     * {@inheritdoc}
     */
    //public function prepareObject(ClassMetadata $metadata)
    //{
    //    die(var_dump($metadata));
    //}
}
