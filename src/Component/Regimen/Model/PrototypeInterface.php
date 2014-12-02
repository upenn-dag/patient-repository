<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Regimen\Model;

use Doctrine\Common\Collections\ollection;
use Accard\Component\Prototype\Model\PrototypeInterface as BasePrototypeInterface;
use Accard\Component\Drug\Model\DrugablePrototypeInterface;
use Accard\Component\Activity\Model\PrototypeInterface as ActivityPrototypeInterface;

/**
 * Regimen prototype interface
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PrototypeInterface extends BasePrototypeInterface, DrugablePrototypeInterface
{
    /**
     * Get allowed activity prototypes.
     *
     * @return Collection|ActivityPrototypeInterface[]
     */
    public function getActivityPrototypes();

    /**
     * Test for presence of allowed activity prototype.
     *
     * @param ActivityPrototypeInterface $activityPrototype
     * @return boolean
     */
    public function hasActivityPrototype(ActivityPrototypeInterface $activityPrototype);

    /**
     * Add allowed activity prototype.
     *
     * @param ActivityPrototypeInterface $activityPrototype
     * @return PrototypeInterface
     */
    public function addActivityPrototype(ActivityPrototypeInterface $activityPrototype);

    /**
     * Remove allowed activity prototype.
     *
     * @param ActivityPrototypeInterface $activityPrototype $activityPrototype
     * @return PrototypeInterface
     */
    public function removeActivityPrototype(ActivityPrototypeInterface $activityPrototype);
}
