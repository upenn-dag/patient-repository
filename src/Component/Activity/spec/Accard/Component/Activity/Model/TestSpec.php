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
use Accard\Component\Activity\Model\Conclusion;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Activity\Model\Test');
    }

    function it_implements_Accard_activity_interface()
    {
        $this->shouldImplement('Accard\Component\Activity\Model\ActivityInterface');
    }

    function it_implements_Accard_conclusion_interface()
    {
        $this->shouldImplement('Accard\Component\Activity\Model\TestInterface');
    }


    // Conclusions

    function it_has_empty_collection_for_conclusions_by_default()
    {
        $this->getConclusions()->shouldReturnAnInstanceOf('Doctrine\Common\Collections\Collection');
    }

    function it_can_deny_finding_conclusion(Conclusion $conclusion)
    {
        $this->hasConclusion($conclusion)->shouldReturn(false);
    }

    function it_can_find_conclusion(Conclusion $conclusion)
    {
        $this->addConclusion($conclusion);
        $this->hasConclusion($conclusion)->shouldReturn(true);
    }

    function it_can_add_a_conclusion(Conclusion $conclusion)
    {
        $this->addConclusion($conclusion);
        $this->getConclusions()->shouldHaveCount(1);
    }

    function it_does_not_add_duplicate_conclusions(Conclusion $conclusion)
    {
        $this->addConclusion($conclusion);
        $this->addConclusion($conclusion);
        $this->getConclusions()->shouldHaveCount(1);
    }

    function it_sets_itself_as_test_when_adding_a_conclusion(Conclusion $conclusion)
    {
        $conclusion->setTest($this)->shouldBeCalled();

        $this->addConclusion($conclusion);
    }

    function it_can_remove_a_conclusion(Conclusion $conclusion)
    {
        $this->addConclusion($conclusion);
        $this->removeConclusion($conclusion);
        $this->getConclusions()->shouldHaveCount(0);
    }

    function it_nullifys_test_when_removing_a_conclusion(Conclusion $conclusion)
    {
        $this->addConclusion($conclusion);
        $conclusion->setTest(null)->shouldBeCalled();
        $this->removeConclusion($conclusion);
    }


    // Fluency

    function it_has_fluent_interface(Conclusion $conclusion)
    {
        $this->addConclusion($conclusion)->shouldReturn($this);
        $this->removeConclusion($conclusion)->shouldReturn($this);
    }
}
