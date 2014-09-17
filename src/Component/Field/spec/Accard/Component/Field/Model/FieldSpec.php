<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Field\Model;

use PhpSpec\ObjectBehavior;
use Accard\Component\Field\Model\FieldTypes;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Field\Model\Field');
    }

    function it_implements_Accard_attribute_interface()
    {
        $this->shouldImplement('Accard\Component\Field\Model\FieldInterface');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_name_by_default()
    {
        $this->getName()->shouldReturn(null);
    }

    function its_name_is_mutable()
    {
        $this->setName('name');
        $this->getName()->shouldReturn('name');
    }

    function it_returns_name_when_converted_to_string()
    {
        $this->setName('name');
        $this->__toString()->shouldReturn('name');
    }

    function it_has_no_presentation_by_default()
    {
        $this->getPresentation()->shouldReturn(null);
    }

    function its_presentation_is_mutable()
    {
        $this->setPresentation('presentation');
        $this->getPresentation()->shouldReturn('presentation');
    }

    function it_has_text_type_by_default()
    {
        $this->getType()->shouldReturn(FieldTypes::TEXT);
    }

    function its_type_is_mutable()
    {
        $this->setType(FieldTypes::CHECKBOX);
        $this->getType()->shouldReturn(FieldTypes::CHECKBOX);
    }

    function it_initializes_empty_configuration_array_by_default()
    {
        $this->getConfiguration()->shouldReturn(array());
    }

    function its_configuration_is_mutable()
    {
        $this->setConfiguration(array('config' => array('one', 'two')));
        $this->getConfiguration()->shouldReturn(array('config' => array('one', 'two')));
    }

    function it_has_fluent_interface()
    {
        $date = new \DateTime();

        $this->setName('name')->shouldReturn($this);
        $this->setPresentation('presentation')->shouldReturn($this);
        $this->setType(FieldTypes::CHOICE)->shouldReturn($this);
        $this->setConfiguration(array())->shouldReturn($this);
    }
}
