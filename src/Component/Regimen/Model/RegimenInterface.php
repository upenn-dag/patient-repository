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

use DateTime;
use Doctrine\Common\Collections\Collection;
use Accard\Component\Prototype\Model\PrototypeSubjectInterface;
use Accard\Component\Field\Model\FieldSubjectInterface;
use Accard\Component\Resource\Model\ResourceInterface;
use Accard\Component\Drug\Model\DrugInterface;

/**
 * Basic regimen interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface RegimenInterface extends PrototypeSubjectInterface,
                                   FieldSubjectInterface,
                                   ResourceInterface
{
    /**
     * Get regimen id.
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
     * @return RegimenInterface
     */
    public function setStartDate(DateTime $startDate);

    /**
     * Get end date.
     *
     * @return DateTime|null
     */
    public function getEndDate();

    /**
     * Set end date.
     *
     * @param DateTime $endDate
     * @return RegimenInterface
     */
    public function setEndDate(DateTime $endDate = null);

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
