<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\RegimenBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Regimen\Model\RegimenInterface;
use Accard\Component\Regimen\Model\PrototypeInterface;
use Accard\Component\Activity\Model\ActivityInterface;
use Accard\Component\Activity\Model\PrototypeInterface as ActivityPrototypeInterface;

/**
 * Regimen activities choice model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenActivitiesChoice
{
    /**
     * Regimen.
     *
     * @var RegimenInterface
     */
    private $regimen;

    /**
     * Activities.
     *
     * @var ArrayCollection|ActivityInterface[]
     */
    private $activities;


    /**
     * Constructor.
     */
    public function __construct(RegimenInterface $regimen)
    {
        $this->regimen = $regimen;
    }

    /**
     * Get activities (proxy).
     *
     * @return ActivityInterface[]
     */
    public function getActivities()
    {
        return $this->regimen->getActivities();
    }

    /**
     * Test for presence of activity (proxy).
     *
     * @param ActivityInterface $activity
     * @return boolean
     */
    public function hasActivity(ActivityInterface $activity)
    {
        return $this->regimen->hasActivity($activity);
    }

    /**
     * Add activity (proxy).
     *
     * @param ActivityInterface $activity
     * @return RegimenInterface
     */
    public function addActivity(ActivityInterface $activity)
    {
        return $this->regimen->addActivity($activity);
    }

    /**
     * Remove activity (proxy).
     *
     * @param ActivityInterface $activity
     * @return RegimenInterface
     */
    public function removeActivity(ActivityInterface $activity)
    {
        return $this->regimen->removeActivity($activity);
    }

    /**
     * Get allowed activities.
     *
     * @return ActivityPrototypeInterface[]
     */
    public function getAllowedActivities()
    {
        return $this->prototype->getActivityPrototypes();
    }

    /**
     * Get count of allowed activities.
     *
     * @return integer
     */
    public function getAllowedActivityCount()
    {
        return count($this->getAllowedActivities());
    }
}
