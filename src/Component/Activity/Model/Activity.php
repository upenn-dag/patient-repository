<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Model;

use DateTime;
use Accard\Component\Prototype\Model\PrototypeInterface as BasePrototypeInterface;

/**
 * Accard activity model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Activity implements ActivityInterface
{
    /**
     * Activity id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Prototype.
     *
     * @var PrototypeInterface
     */
    protected $prototype;

    /**
     * Activity date.
     *
     * @var DateTime
     */
    protected $activityDate;


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
    public function getPrototype()
    {
        return $this->prototype;
    }

    /**
     * {@inheritdoc}
     */
    public function setPrototype(BasePrototypeInterface $prototype = null)
    {
        $this->prototype = $prototype;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivityDate()
    {
        return $this->activityDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setActivityDate(DateTime $activityDate)
    {
        $this->activityDate = $activityDate;

        return $this;
    }
}
