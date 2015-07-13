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
 * Orderable trait.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait OrderableTrait
{
    /**
     * Order.
     *
     * @var integer
     */
    protected $order = 0;


    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }
}
