<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Patient\Model;

use PhpSpec\ObjectBehavior;
use Accard\Component\Patient\Model\PatientInterface;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Patient\Model\FieldValue');
    }

    function it_extends_Accard_attribute_value_model()
    {
        $this->shouldHaveType('Accard\Component\Field\Model\FieldValue');
    }

    function it_implements_Accard_patient_attribute_value_interface()
    {
        $this->shouldImplement('Accard\Component\Patient\Model\FieldValueInterface');
    }

    function it_does_not_belong_to_a_patient_by_default()
    {
        $this->getPatient()->shouldReturn(null);
    }

    function it_allows_assigning_itself_to_a_patient(PatientInterface $patient)
    {
        $this->setPatient($patient);
        $this->getPatient()->shouldReturn($patient);
    }

    function it_allows_detaching_itself_from_a_patient(PatientInterface $patient)
    {
        $this->setPatient($patient);
        $this->getPatient()->shouldReturn($patient);

        $this->setPatient(null);
        $this->getPatient()->shouldReturn(null);
    }
}