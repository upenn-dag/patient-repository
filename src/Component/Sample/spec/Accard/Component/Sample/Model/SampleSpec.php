<?php

namespace spec\Accard\Component\Sample\Model;

use Accard\Component\Sample\Model\Sample;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SampleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Sample\Model\Sample');
    }

    function it_implements_Accard_sample_interface()
    {
        $this->shouldImplement('Accard\Component\Sample\Model\SampleInterface');
    }


    // Id

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }


    // Parent

    function it_has_no_parent_by_default()
    {
        $this->getParent()->shouldReturn(null);
    }

    function its_parent_is_mutable(Sample $parent)
    {
        $this->setParent($parent);
        $this->getParent()->shouldReturn($parent);
    }

    function its_parent_is_nullable()
    {
        $this->setParent(null);
        $this->getParent()->shouldReturn(null);
    }

    function its_a_source_sample_if_parent_is_blank()
    {
        $this->shouldBeSource();
    }

    function its_a_derivative_sample_if_parent_is_set(Sample $sample)
    {
        $this->setParent($sample);
        $this->shouldBeDerivative();
    }


    // Amount

    function its_amount_is_zero_by_default()
    {
        $this->getAmount()->shouldReturn(0);
    }

    function its_amount_is_mutable()
    {
        $this->setAmount(1);
        $this->getAmount()->shouldReturn(1);
    }

    function it_crawls_all_samples_to_calculate_amount_remaining(Sample $sample)
    {
        $sample->setParent($this)->shouldBeCalled();
        $sample->getAmount()->willReturn(5);

        $this->setAmount(10);
        $this->addChild($sample);
        $this->getAmountRemaining()->shouldReturn(5);
    }


    // Amount of parent used

    function it_has_no_parent_amount_by_default()
    {
        $this->getAmountOfParentUsed()->shouldReturn(null);
    }

    function its_parent_amount_is_mutable()
    {
        $this->setAmountOfParentUsed(1);
        $this->getAmountOfParentUsed()->shouldReturn(1);
    }

    function its_parent_amount_is_nullable()
    {
        $this->setAmountOfParentUsed(null);
        $this->getAmountOfParentUsed()->shouldReturn(null);
    }


    // Children

    function it_has_empty_collection_for_children_by_default()
    {
        $this->getChildren()->shouldReturnAnInstanceOf('Doctrine\Common\Collections\Collection');
    }

    function it_can_deny_finding_sample(Sample $sample)
    {
        $this->hasChild($sample)->shouldReturn(false);
    }

    function it_can_find_sample(Sample $sample)
    {
        $this->addChild($sample);
        $this->hasChild($sample)->shouldReturn(true);
    }

    function it_can_add_a_sample(Sample $sample)
    {
        $this->addChild($sample);
        $this->getChildren()->shouldHaveCount(1);
    }

    function it_does_not_add_duplicate_children(Sample $sample)
    {
        $this->addChild($sample);
        $this->addChild($sample);
        $this->getChildren()->shouldHaveCount(1);
    }

    function it_sets_itself_as_parent_when_adding_a_sample(Sample $sample)
    {
        $sample->setParent($this)->shouldBeCalled();

        $this->addChild($sample);
    }

    function it_can_remove_a_sample(Sample $sample)
    {
        $this->addChild($sample);
        $this->removeChild($sample);
        $this->getChildren()->shouldHaveCount(0);
    }

    function it_nullifys_parent_when_removing_a_sample(Sample $sample)
    {
        $this->addChild($sample);
        $sample->setParent(null)->shouldBeCalled();
        $this->removeChild($sample);
    }


    // Fluency

    function it_has_fluent_interface(Sample $sample)
    {
        $this->setParent($sample)->shouldReturn($this);
        $this->addChild($sample)->shouldReturn($this);
        $this->removeChild($sample)->shouldReturn($this);
    }
}
