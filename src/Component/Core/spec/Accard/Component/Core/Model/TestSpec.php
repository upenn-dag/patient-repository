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
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TestSpec extends ModelBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Core\Model\Test');
    }

    function it_implements_Accard_collection_interface()
    {
        $this->shouldImplement('Accard\Component\Core\Model\TestInterface');
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
}
