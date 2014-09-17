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
use Accard\Component\Prototype\Model\PrototypeSubjectInterface;

/**
 * Basic activity interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ActivityInterface extends PrototypeSubjectInterface
{
    /**
     * Get activity id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get activity date.
     *
     * @return DateTime
     */
    public function getActivityDate();

    /**
     * Set activity date.
     *
     * @param DateTime $activityDate
     * @return ActivityInterface
     */
    public function setActivityDate(DateTime $activityDate);
}
