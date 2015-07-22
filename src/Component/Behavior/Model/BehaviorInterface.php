<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Behavior\Model;

use DateTime;
use Doctrine\Common\Collections\Collection;
use DAG\Component\Prototype\Model\PrototypeSubjectInterface;
use DAG\Component\Field\Model\FieldSubjectInterface;
use DAG\Component\Resource\Model\ResourceInterface;

/**
 * Basic behavior interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface BehaviorInterface extends PrototypeSubjectInterface,
                                    FieldSubjectInterface,
                                    ResourceInterface
{
    /**
     * Get behavior id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get start date.
     *
     * @return DateTime
     */
    public function getStartDate();

    /**
     * Set start date.
     *
     * @param DateTime $startDate
     * @return BehaviorInterface
     */
    public function setStartDate(DateTime $startDate);

    /**
     * Get end date.
     *
     * @return DateTime|null $endDate
     */
    public function getEndDate();

    /**
     * Set end date.
     *
     * @param DateTime|null $endDate
     * @return BehaviorInterface
     */
    public function setEndDate(DateTime $endDate = null);
}
