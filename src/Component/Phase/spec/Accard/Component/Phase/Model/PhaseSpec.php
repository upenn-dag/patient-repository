<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Phase\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use DateTime;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PhaseSpec extends ObjectBehavior
{
    // Class

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Phase\Model\Phase');
    }

    function it_implements_Accard_phase_interface()
    {
        $this->shouldImplement('Accard\Component\Phase\Model\PhaseInterface');
    }

    // Id

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
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

    function it_is_ongoing_if_end_date_is_blank()
    {
        $this->shouldBeOngoing();
    }

    function it_is_ongoing_if_end_date_is_in_the_future()
    {
        $date = new DateTime('tomorrow');
        $this->setEndDate($date);

        $this->shouldBeOngoing();
    }

    function it_is_not_ongoing_if_end_date_has_passed()
    {
        $date = new DateTime('yesterday');
        $this->setEndDate($date);

        $this->shouldNotBeOngoing();
    }


    // Label

    function it_has_no_label_by_default()
    {
        $this->getLabel()->shouldReturn(null);
    }

    function its_label_is_mutable()
    {
        $this->setLabel('label');
        $this->getLabel()->shouldReturn('label');
    }
}
