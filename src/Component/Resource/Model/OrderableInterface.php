<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Model;

/**
 * Ordering interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface OrderableInterface
{
    /**
     * Get order.
     *
     * @return integer
     */
    public function getOrder();

    /**
     * Set order.
     *
     * @param integer $order
     */
    public function setOrder($currentOrdering);
}
