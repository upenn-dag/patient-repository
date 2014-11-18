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
use Accard\Component\Field\Model\FieldSubjectInterface;
use Accard\Component\Resource\Model\ResourceInterface;
use Accard\Component\Drug\Model\DrugInterface;

/**
 * Basic activity interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ActivityInterface extends PrototypeSubjectInterface,
                                    FieldSubjectInterface,
                                    ResourceInterface
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

    /**
     * Get drug.
     *
     * @return DrugInterface
     */
    public function getDrug();

    /**
     * Set drug (optional).
     *
     * @param DrugInterface|null $drug
     * @return ActivityInterface
     */
    public function setDrug(DrugInterface $drug = null);

    /**
     * Test if activity allows drug to be set (proxy).
     *
     * @return boolean
     */
    public function isDruggable();
}
