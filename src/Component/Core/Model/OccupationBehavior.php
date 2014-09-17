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
 * Accard occupation behavior model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class OccupationBehavior extends Behavior implements OccupationBehaviorInterface
{
    /**
     * Past industry
     *
     * @var string
     */
    protected $industry;

    /**
     * Weekly hours
     *
     * @var string
     */
    protected $hours;

    /**
     * {@inheritdoc}
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * {@inheritdoc}
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHours()
    {
        return $this->hours;
    }
}
