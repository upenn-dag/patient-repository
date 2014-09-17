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

use Accard\Component\Core\Model\Diagnosis;
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisPhaseSpec extends ModelBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Core\Model\DiagnosisPhase');
    }

    function it_implements_Accard_activity_interface()
    {
        $this->shouldImplement('Accard\Component\Core\Model\DiagnosisPhaseInterface');
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
