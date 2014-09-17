<?php

namespace spec\Accard\Component\Attribute\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttributeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Attribute\Model\Attribute');
    }

    function it_implements_Accard_attribute_interface()
    {
        $this->shouldImplement('Accard\Component\Attribute\Model\AttributeInterface');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }
}
