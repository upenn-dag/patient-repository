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
use Accard\Component\Regimen\Model\PrototypeInterface;
use Accard\Component\Activity\Model\ActivityInterface;
use Accard\Component\Activity\Model\PrototypeInterface as ActivityPrototypeInterface;

/**
 * Regimen activities model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenActivities
{
    /**
     * Regimen prototype.
     *
     * @var PrototypeInterface
     */
    private $prototype;

    /**
     * Activities.
     *
     * @var ArrayCollection|ActivityInterface[]
     */
    private $activities;

    /**
     * Allowed activities.
     *
     * @var ArrayCollection|ActivityPrototypeInterface[]
     */
    private $allowedActivities;

    /**
     * Count of allowed activities.
     *
     * @var integer
     */
    private $allowedActivityCount;


    /**
     * Constructor.
     */
    public function __construct(PrototypeInterface $prototype)
    {
        $this->prototype = $prototype;
        $this->activities = new ArrayCollection();
        $this->allowedActivities = $prototype->getActivityPrototypes();
        $this->allowedActivityCount = count($this->allowedActivities);
    }

    /**
     * Get count of allowed activities.
     *
     * @return integer
     */
    public function getAllowedActivityCount()
    {
        return $this->allowedActivityCount;
    }
}
