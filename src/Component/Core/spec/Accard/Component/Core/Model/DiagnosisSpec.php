<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Core\Model;

require_once __DIR__.'/ModelBehavior.php';

use Accard\Component\Core\Model\Patient;
use Accard\Component\Core\Model\Diagnosis;
use Accard\Component\Core\Model\Activity;
use Accard\Component\Core\Model\DiagnosisPhase;
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisSpec extends ModelBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Core\Model\Diagnosis');
    }

    function it_implements_Accard_activity_interface()
    {
        $this->shouldImplement('Accard\Component\Core\Model\DiagnosisInterface');
    }


    // Patient

    function it_has_no_patient_by_default()
    {
        $this->getPatient()->shouldReturn(null);
    }

    function its_patient_is_mutable(Patient $patient)
    {
        $this->setPatient($patient);
        $this->getPatient()->shouldReturn($patient);
    }

    function its_patient_is_nullable()
    {
        $this->setPatient(null);
        $this->getPatient()->shouldReturn(null);
    }



    // Activities

    function it_has_empty_collection_for_activities_by_default()
    {
        $this->getActivities()->shouldReturnAnInstanceOf('Doctrine\Common\Collections\Collection');
    }

    function it_can_deny_finding_activity(Activity $activity)
    {
        $this->hasActivity($activity)->shouldReturn(false);
    }

    function it_can_find_activity(Activity $activity)
    {
        $this->addActivity($activity);
        $this->hasActivity($activity)->shouldReturn(true);
    }

    function it_can_add_a_activity(Activity $activity)
    {
        $this->addActivity($activity);
        $this->getActivities()->shouldHaveCount(1);
    }

    function it_does_not_add_duplicate_activities(Activity $activity)
    {
        $this->addActivity($activity);
        $this->addActivity($activity);
        $this->getActivities()->shouldHaveCount(1);
    }

    function it_sets_itself_as_diagnosis_when_adding_a_activity(Activity $activity)
    {
        $activity->setDiagnosis($this)->shouldBeCalled();

        $this->addActivity($activity);
    }

    function it_can_remove_a_activity(Activity $activity)
    {
        $this->addActivity($activity);
        $this->removeActivity($activity);
        $this->getActivities()->shouldHaveCount(0);
    }

    function it_nullifys_diagnosis_when_removing_a_activity(Activity $activity)
    {
        $this->addActivity($activity);
        $activity->setDiagnosis(null)->shouldBeCalled();
        $this->removeActivity($activity);
    }


    // Diagnosis phases

    function it_has_empty_collection_for_phases_by_default()
    {
        $this->getPhases()->shouldReturnAnInstanceOf('Doctrine\Common\Collections\Collection');
    }

    function it_can_deny_finding_phase(DiagnosisPhase $phase)
    {
        $this->hasPhase($phase)->shouldReturn(false);
    }

    function it_can_find_phase(DiagnosisPhase $phase)
    {
        $this->addPhase($phase);
        $this->hasPhase($phase)->shouldReturn(true);
    }

    function it_can_add_a_phase(DiagnosisPhase $phase)
    {
        $this->addPhase($phase);
        $this->getPhases()->shouldHaveCount(1);
    }

    function it_does_not_add_duplicate_phases(DiagnosisPhase $phase)
    {
        $this->addPhase($phase);
        $this->addPhase($phase);
        $this->getPhases()->shouldHaveCount(1);
    }

    function it_sets_itself_as_patient_when_adding_a_phase(DiagnosisPhase $phase)
    {
        $phase->setDiagnosis($this)->shouldBeCalled();

        $this->addPhase($phase);
    }

    function it_can_remove_a_phase(DiagnosisPhase $phase)
    {
        $this->addPhase($phase);
        $this->removePhase($phase);
        $this->getPhases()->shouldHaveCount(0);
    }

    function it_nullifys_patient_when_removing_a_phase(DiagnosisPhase $phase)
    {
        $this->addPhase($phase);
        $phase->setDiagnosis(null)->shouldBeCalled();
        $this->removePhase($phase);
    }
}
