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
 * Accard SmokingBehavior model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class SmokingBehavior extends Behavior implements SmokingBehaviorInterface
{
    /**
     * Type of smoking (like cigarettes, cigars, etc)
     *
     * @var string
     */
    protected $type;

    /**
     * Frequency of smoking.
     *
     * @var integer
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
