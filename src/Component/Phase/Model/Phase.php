<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Phase\Model;

/**
 * Accard phase model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Phase implements PhaseInterface
{
    /**
     * Phase id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Label.
     *
     * @var string
     */
    protected $label;

    /**
     * Presentation.
     *
     * @var string
     */
    protected $presentation;

    /**
     * Order.
     *
     * @var integer
     */
    protected $order = 99;


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * {@inheritdoc}
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

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
