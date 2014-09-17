<?php


/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Core\Model;

use Doctrine\Common\Collections\Collection;
use Accard\Component\Patient\Model\PatientInterface as BasePatientInterface;
use Accard\Component\Resource\Model\BlameableInterface;
use Accard\Component\Resource\Model\VersionableInterface;
use Accard\Component\Resource\Model\TimestampableInterface;
use Accard\Component\Phase\Model\PhaseTargetInterface;

/**
 * Accard patient interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PatientInterface extends BasePatientInterface,
                                   TimestampableInterface,
                                   BlameableInterface,
                                   VersionableInterface,
                                   PhaseTargetInterface
{
    /**
     * Get diagnoses.
     *
     * @return Collection|DiagnosisInterface[]
     */
    public function getDiagnoses();

    /**
     * Test for presence of a diagnosis.
     *
     * @param DiagnosisInterface $diagnosis
     * @return boolean
     */
    public function hasDiagnosis(DiagnosisInterface $diagnosis);

    /**
     * Add diagnosis.
     *
     * @param DiagnosisInterface $diagnosis
     * @return PatientInterface
     */
    public function addDiagnosis(DiagnosisInterface $diagnosis);

    /**
     * Remove diagnosis.
     *
     * @param DiagnosisInterface $diagnosis
     * @return PatientInterface
     */
    public function removeDiagnosis(DiagnosisInterface $diagnosis);

    /**
     * Get activities.
     *
     * @return Collection|ActivityInterface[]
     */
    public function getActivities();

    /**
     * Test for presence of a activity.
     *
     * @param ActivityInterface $activity
     * @return boolean
     */
    public function hasActivity(ActivityInterface $activity);

    /**
     * Add activity.
     *
     * @param ActivityInterface $activity
     * @return PatientInterface
     */
    public function addActivity(ActivityInterface $activity);

    /**
     * Remove activity.
     *
     * @param ActivityInterface $activity
     * @return PatientInterface
     */
    public function removeActivity(ActivityInterface $activity);

    /**
     * Get behaviors.
     *
     * @return Collection|BehaviorInterface[]
     */
    public function getBehaviors();

    /**
     * Test for presence of a behavior.
     *
     * @param BehaviorInterface $behavior
     * @return boolean
     */
    public function hasBehavior(BehaviorInterface $behavior);

    /**
     * Add a behavior.
     *
     * @param BehaviorInterface $behavior
     * @return PatientInterface
     */
    public function addBehavior(BehaviorInterface $behavior);

    /**
     * Remove a behavior.
     *
     * @param BehaviorInterface $behavior
     * @return PatientInterface
     */
    public function removeBehavior(BehaviorInterface $behavior);

    /**
     * Get attributes.
     *
     * @return Collection|AttributeInterface[]
     */
    public function getAttributes();

    /**
     * Test for presence of an attribute.
     *
     * @param AttributeInterface $attribute
     * @return boolean
     */
    public function hasAttribute(AttributeInterface $attribute);

    /**
     * Add an attribute.
     *
     * @param AttributeInterface $attribute
     * @return PatientInterface
     */
    public function addAttribute(AttributeInterface $attribute);

    /**
     * Remove an attribute.
     *
     * @param AttributeInterface $attribute
     * @return PatientInterface
     */
    public function removeAttribute(AttributeInterface $attribute);

    /**
     * Get phases.
     *
     * @return Collection|PatientPhaseInstanceInterface[]
     */
    public function getPhases();

    /**
     * Test for presence of a phase.
     *
     * @param PatientPhaseInstanceInterface $phase
     * @return boolean
     */
    public function hasPhase(PatientPhaseInstanceInterface $phase);

    /**
     * Add phase.
     *
     * @param PatientPhaseInstanceInterface $phase
     * @return PatientInterface
     */
    public function addPhase(PatientPhaseInstanceInterface $phase);

    /**
     * Remove phase.
     *
     * @param PatientPhaseInstanceInterface $phase
     * @return PatientInterface
     */
    public function removePhase(PatientPhaseInstanceInterface $phase);
}
