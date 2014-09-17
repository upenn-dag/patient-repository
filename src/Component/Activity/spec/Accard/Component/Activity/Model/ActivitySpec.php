<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Activity\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivitySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Activity\Model\Activity');
    }

    function it_implements_Accard_activity_interface()
    {
        $this->shouldImplement('Accard\Component\Activity\Model\ActivityInterface');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_activity_date_by_default()
    {
        $this->getActivityDate()->shouldReturn(null);
    }

    function its_activity_date_is_mutable()
    {
        $date = new \DateTime();
        $this->setActivityDate($date);
        $this->getActivityDate()->shouldReturn($date);
    }
}
