<?php


/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Test\Stub;

use Accard\Component\Resource\Builder\AbstractBuilder;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Stub builder.
 *
 * Serves as an implementation of the abstract builder for test purposes.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Builder extends AbstractBuilder
{
    /**
     * Constructor.
     *
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
}
