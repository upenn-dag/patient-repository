<?php


/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Builder;

use Accard\Component\Resource\Exception\InvalidResourceException;

/**
 * Basic builder interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface BuilderInterface
{
    /**
     * Get builder resource.
     *
     * @return object
     */
    public function get();

    /**
     * Replace builder resource.
     *
     * @param object $resource
     * @return BuilderInterface
     */
    public function set($resource);

    /**
     * Save the builder resource.
     *
     * @param boolean $flush
     * @return object
     */
    public function save($flush = true);
}
