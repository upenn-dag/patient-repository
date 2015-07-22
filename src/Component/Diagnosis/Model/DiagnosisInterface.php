<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Diagnosis\Model;

use DateTime;
use Doctrine\Common\Collections\Collection;
use DAG\Component\Field\Model\FieldSubjectInterface;
use DAG\Component\Resource\Model\ResourceInterface;

/**
 * Basic diagnosis interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface DiagnosisInterface extends FieldSubjectInterface, ResourceInterface
{
    /**
     * Get diagnosis id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get parent diagnosis.
     *
     * @return DiagnosisInterface
     */
    public function getParent();

    /**
     * Set parent diagnosis.
     *
     * @param DiagnosisInterface|null $parent
     * @return DiagnosisInterface
     */
    public function setParent(DiagnosisInterface $parent = null);

    /**
     * Get primary diagnosis.
     *
     * @return DiagnosisInterface
     */
    public function getPrimary();

    /**
     * Set primary diagnosis.
     *
     * @param DiagnosisInterface|null $rimary
     * @return DiagnosisInterface
     */
    public function setPrimary(DiagnosisInterface $primary = null);

    /**
     * Get diagnosis code.
     *
     * @return CodeInterace
     */
    public function getCode();

    /**
     * Set code interface.
     *
     * @param CodeInterface $code
     * @return DiagnosisInterface
     */
    public function setCode(CodeInterface $code);

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
     * @return DiagnosisInterface
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
     * @return DiagnosisInterface
     */
    public function setEndDate(DateTime $endDate = null);

    /**
     * Test ongoing.
     *
     * @return boolean
     */
    public function isOngoing();

    /**
     * Get recurrences.
     *
     * @return Collection|DiagnosisInterface[]
     */
    public function getRecurrences();

    /**
     * Test for presence of recurrence.
     *
     * @param DiagnosisInterface $recurrence
     * @return boolean
     */
    public function hasRecurrence(DiagnosisInterface $recurrence);

    /**
     * Add recurrence.
     *
     * @param DiagnosisInterface $recurrence
     * @return DiagnosisInterface
     */
    public function addRecurrence(DiagnosisInterface $recurrence);

    /**
     * Remove recurrence.
     *
     * @param DiagnosisInterface $recurrence
     * @return DiagnosisInterface
     */
    public function removeRecurrence(DiagnosisInterface $recurrence);

    /**
     * Get comorbidities.
     *
     * @return Collection|DiagnosisInterface[]
     */
    public function getComorbidities();

    /**
     * Test for presence of comorbidity.
     *
     * @param DiagnosisInterface $comorbidity
     * @return boolean
     */
    public function hasComorbidity(DiagnosisInterface $comorbidity);

    /**
     * Add comorbidity.
     *
     * @param DiagnosisInterface $comorbidity
     * @return DiagnosisInterface
     */
    public function addComorbidity(DiagnosisInterface $comorbidity);

    /**
     * Remove comorbidity.
     *
     * @param DiagnosisInterface $comorbidity
     * @return DiagnosisInterface
     */
    public function removeComorbidity(DiagnosisInterface $comorbidity);
}
