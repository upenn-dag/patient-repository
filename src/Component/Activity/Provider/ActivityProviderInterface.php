<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Provider;

use Accard\Component\Resource\Provider\ProviderInterface;
use Accard\Component\Activity\Model\ActivityInterface;
use Accard\Component\Activity\Model\PrototypeInterface;
use Accard\Component\Activity\Exception\ActivityNotFoundException;
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;

/**
 * Activity provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ActivityProviderInterface extends PrototypeProviderInterface, ProviderInterface
{
    /**
     * Get model FQCN.
     *
     * @return string
     */
    public function getActivityModelClass();

    /**
     * Test for presence of activity.
     *
     * @param integer $activityId
     * @return boolean
     */
    public function hasActivity($activityId);

    /**
     * Get activity.
     *
     * @throws ActivityNotFoundException If activity can not be found.
     * @param integer $activityId
     * @return ActivityInterface
     */
    public function getActivity($activityId);
}
