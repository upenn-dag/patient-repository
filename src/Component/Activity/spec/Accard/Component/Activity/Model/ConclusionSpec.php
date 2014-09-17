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
use Accard\Component\Activity\Model\Test;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ConclusionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Activity\Model\Conclusion');
    }

    function it_implements_Accard_activity_interface()
    {
        $this->shouldImplement('Accard\Component\Activity\Model\ActivityInterface');
    }

    function it_implements_Accard_conclusion_interface()
    {
        $this->shouldImplement('Accard\Component\Activity\Model\ConclusionInterface');
    }

    function it_has_no_test_by_default()
    {
        $this->getTest()->shouldReturn(null);
    }

    function its_test_is_mutable(Test $test)
    {
        $this->setTest($test);
        $this->getTest()->shouldReturn($test);
    }
}
