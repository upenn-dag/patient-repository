<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Diagnosis\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Accard\Component\Diagnosis\Model\Diagnosis;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisSpec extends ObjectBehavior
{
    // Class

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Diagnosis\Model\Diagnosis');
    }

    function it_implements_Accard_diagnosis_interface()
    {
        $this->shouldImplement('Accard\Component\Diagnosis\Model\DiagnosisInterface');
    }


    // Id

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }


    // Primary

    function it_has_no_primary_by_default()
    {
        $this->getPrimary()->shouldReturn(null);
    }

    function its_primary_is_mutable(Diagnosis $primary)
    {
        $this->setPrimary($primary);
        $this->getPrimary()->shouldReturn($primary);
    }

    function its_primary_is_nullable()
    {
        $this->setPrimary(null);
        $this->getPrimary()->shouldReturn(null);
    }


    // Parent

    function it_has_no_parent_by_default()
    {
        $this->getParent()->shouldReturn(null);
    }

    function its_parent_is_mutable(Diagnosis $parent)
    {
        $this->setParent($parent);
        $this->getParent()->shouldReturn($parent);
    }

    function its_parent_is_nullable()
    {
        $this->setParent(null);
        $this->getParent()->shouldReturn(null);
    }


    // Recurrences

    function it_has_empty_collection_for_recurrences_by_default()
    {
        $this->getRecurrences()->shouldReturnAnInstanceOf('Doctrine\Common\Collections\Collection');
    }

    function it_can_deny_finding_recurrence(Diagnosis $recurrence)
    {
        $this->hasRecurrence($recurrence)->shouldReturn(false);
    }

    function it_can_find_recurrence(Diagnosis $recurrence)
    {
        $this->addRecurrence($recurrence);
        $this->hasRecurrence($recurrence)->shouldReturn(true);
    }

    function it_can_add_a_recurrence(Diagnosis $recurrence)
    {
        $this->addRecurrence($recurrence);
        $this->getRecurrences()->shouldHaveCount(1);
    }

    function it_does_not_add_duplicate_recurrences(Diagnosis $recurrence)
    {
        $this->addRecurrence($recurrence);
        $this->addRecurrence($recurrence);
        $this->getRecurrences()->shouldHaveCount(1);
    }

    function it_sets_itself_as_primary_when_adding_a_recurrence(Diagnosis $recurrence)
    {
        $recurrence->setPrimary($this)->shouldBeCalled();

        $this->addRecurrence($recurrence);
    }

    function it_can_remove_a_recurrence(Diagnosis $recurrence)
    {
        $this->addRecurrence($recurrence);
        $this->removeRecurrence($recurrence);
        $this->getRecurrences()->shouldHaveCount(0);
    }

    function it_nullifys_primary_when_removing_a_recurrence(Diagnosis $recurrence)
    {
        $this->addRecurrence($recurrence);
        $recurrence->setPrimary(null)->shouldBeCalled();
        $this->removeRecurrence($recurrence);
    }

    // Comorbidities

    function it_has_empty_collection_for_comorbidities_by_default()
    {
        $this->getComorbidities()->shouldReturnAnInstanceOf('Doctrine\Common\Collections\Collection');
    }

    function it_can_deny_finding_comorbidity(Diagnosis $recurrence)
    {
        $this->hasComorbidity($recurrence)->shouldReturn(false);
    }

    function it_can_find_comorbidity(Diagnosis $comorbidity)
    {
        $this->addComorbidity($comorbidity);
        $this->hasComorbidity($comorbidity)->shouldReturn(true);
    }

    function it_can_add_a_comorbidity(Diagnosis $comorbidity)
    {
        $this->addComorbidity($comorbidity);
        $this->getComorbidities()->shouldHaveCount(1);
    }

    function it_does_not_add_duplicate_comorbidities(Diagnosis $comorbidity)
    {
        $this->addComorbidity($comorbidity);
        $this->addComorbidity($comorbidity);
        $this->getComorbidities()->shouldHaveCount(1);
    }

    function it_sets_itself_as_primary_when_adding_a_comorbidity(Diagnosis $comorbidity)
    {
        $comorbidity->setParent($this)->shouldBeCalled();

        $this->addComorbidity($comorbidity);
    }

    function it_can_remove_a_comorbidity(Diagnosis $comorbidity)
    {
        $this->addComorbidity($comorbidity);
        $this->removeComorbidity($comorbidity);
        $this->getComorbidities()->shouldHaveCount(0);
    }

    function it_nullifys_primary_when_removing_a_comorbidity(Diagnosis $comorbidity)
    {
        $this->addComorbidity($comorbidity);
        $comorbidity->setParent(null)->shouldBeCalled();
        $this->removeComorbidity($comorbidity);
    }


    // Start date

    function it_has_no_start_date_by_default()
    {
        $this->getStartDate()->shouldReturn(null);
    }

    function its_start_date_is_mutable()
    {
        $date = new \DateTime();
        $this->setStartDate($date);
        $this->getStartDate()->shouldReturn($date);
    }

    // End date

    function it_has_no_end_date_by_default()
    {
        $this->getEndDate()->shouldReturn(null);
    }

    function its_end_date_is_mutable()
    {
        $date = new \DateTime();
        $this->setEndDate($date);
        $this->getEndDate()->shouldReturn($date);
    }

    function its_end_date_is_nullable()
    {
        $this->setEndDate(null);
        $this->getEndDate()->shouldReturn(null);
    }


    // Fluency

    function it_has_fluent_interface(Diagnosis $primary, Diagnosis $parent)
    {
        $date = new \DateTime();

        $this->setPrimary($primary)->shouldReturn($this);
        $this->setParent($parent)->shouldReturn($this);
        $this->setStartDate($date)->shouldReturn($this);
        $this->setEndDate($date)->shouldReturn($this);
        $this->addRecurrence($primary)->shouldReturn($this);
        $this->removeRecurrence($primary)->shouldReturn($this);
        $this->addComorbidity($parent)->shouldReturn($this);
        $this->removeComorbidity($parent)->shouldReturn($this);
    }
}
