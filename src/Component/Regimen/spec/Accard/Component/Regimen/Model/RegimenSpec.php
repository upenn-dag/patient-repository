<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Regimen\Model;

use Accard\Component\Regimen\Model\Regimen;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Regimen\Model\Regimen');
    }

    function it_implements_Accard_regimen_interface()
    {
        $this->shouldImplement('Accard\Component\Regimen\Model\RegimenInterface');
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

    function its_parent_is_mutable(Regimen $parent)
    {
        $this->setParent($parent);
        $this->getParent()->shouldReturn($parent);
    }

    function its_parent_is_nullable()
    {
        $this->setParent(null);
        $this->getParent()->shouldReturn(null);
    }

    function its_a_parent_regimen_if_parent_is_blank()
    {
        $this->shouldBeParent();
    }

    function its_a_child_regimen_if_parent_is_set(Regimen $regimen)
    {
        $this->setParent($regimen);
        $this->shouldBeChild();
    }


    // Children

    function it_has_empty_collection_for_children_by_default()
    {
        $this->getChildren()->shouldReturnAnInstanceOf('Doctrine\Common\Collections\Collection');
    }

    function it_can_deny_finding_regimen(Regimen $regimen)
    {
        $this->hasChild($regimen)->shouldReturn(false);
    }

    function it_can_find_regimen(Regimen $regimen)
    {
        $this->addChild($regimen);
        $this->hasChild($regimen)->shouldReturn(true);
    }

    function it_can_add_a_regimen(Regimen $regimen)
    {
        $this->addChild($regimen);
        $this->getChildren()->shouldHaveCount(1);
    }

    function it_does_not_add_duplicate_children(Regimen $regimen)
    {
        $this->addChild($regimen);
        $this->addChild($regimen);
        $this->getChildren()->shouldHaveCount(1);
    }

    function it_sets_itself_as_parent_when_adding_a_regimen(Regimen $regimen)
    {
        $regimen->setParent($this)->shouldBeCalled();

        $this->addChild($regimen);
    }

    function it_can_remove_a_regimen(Regimen $regimen)
    {
        $this->addChild($regimen);
        $this->removeChild($regimen);
        $this->getChildren()->shouldHaveCount(0);
    }

    function it_nullifys_parent_when_removing_a_regimen(Regimen $regimen)
    {
        $this->addChild($regimen);
        $regimen->setParent(null)->shouldBeCalled();
        $this->removeChild($regimen);
    }


    // Fluency

    function it_has_fluent_interface(Regimen $regimen)
    {
        $this->setParent($regimen)->shouldReturn($this);
        $this->addChild($regimen)->shouldReturn($this);
        $this->removeChild($regimen)->shouldReturn($this);
    }
}
