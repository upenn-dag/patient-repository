<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Core\Model;

/**
 * Accard illicit drug behavior model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class IllicitDrugBehavior extends Behavior implements IllicitDrugBehaviorInterface
{
    /**
     * Type of illicit drug
     *
     * @var string
     */
    protected $type;

    /**
     * Method of consumption.
     *
     * @var string
     */
    protected $method;

    /**
     * Frequency of consumption.
     *
     * @var string
     */
    protected $frequency;

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrequency()
    {
        return $this->frequency;
    }
}
