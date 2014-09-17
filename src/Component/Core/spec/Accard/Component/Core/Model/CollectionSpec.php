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

use Accard\Component\Core\Model\Patient;
use Accard\Component\Core\Model\Diagnosis;
use Accard\Component\Core\Model\Sample;
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CollectionSpec extends ModelBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Core\Model\Collection');
    }

    function it_implements_Accard_collection_interface()
    {
        $this->shouldImplement('Accard\Component\Core\Model\CollectionInterface');
    }

    function it_implements_Accard_activity_interface()
    {
        $this->shouldImplement('Accard\Component\Core\Model\ActivityInterface');
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

    // Diagnosis

    function it_has_no_diagnosis_by_default()
    {
        $this->getDiagnosis()->shouldReturn(null);
    }

    function its_diagnosis_is_mutable(Diagnosis $diagnosis)
    {
        $this->setDiagnosis($diagnosis);
        $this->getDiagnosis()->shouldReturn($diagnosis);
    }

    function its_diagnosis_is_nullable()
    {
        $this->setDiagnosis(null);
        $this->getDiagnosis()->shouldReturn(null);
    }

    // Samples

    function it_has_empty_collection_for_samples_by_default()
    {
        $this->getSamples()->shouldReturnAnInstanceOf('Doctrine\Common\Collections\Collection');
    }

    function it_can_deny_finding_sample(Sample $sample)
    {
        $this->hasSample($sample)->shouldReturn(false);
    }

    function it_can_find_sample(Sample $sample)
    {
        $this->addSample($sample);
        $this->hasSample($sample)->shouldReturn(true);
    }

    function it_can_add_a_sample(Sample $sample)
    {
        $this->addSample($sample);
        $this->getSamples()->shouldHaveCount(1);
    }

    function it_does_not_add_duplicate_samples(Sample $sample)
    {
        $this->addSample($sample);
        $this->addSample($sample);
        $this->getSamples()->shouldHaveCount(1);
    }

    function it_sets_itself_as_collection_when_adding_a_sample(Sample $sample)
    {
        $sample->setCollection($this)->shouldBeCalled();

        $this->addSample($sample);
    }

    function it_can_remove_a_sample(Sample $sample)
    {
        $this->addSample($sample);
        $this->removeSample($sample);
        $this->getSamples()->shouldHaveCount(0);
    }

    function it_nullifys_collection_when_removing_a_sample(Sample $sample)
    {
        $this->addSample($sample);
        $sample->setCollection(null)->shouldBeCalled();
        $this->removeSample($sample);
    }
}
