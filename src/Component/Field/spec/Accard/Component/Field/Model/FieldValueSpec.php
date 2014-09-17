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
use Accard\Component\Field\Model\FieldInterface;
use Accard\Component\Field\Model\FieldTypes;
use Accard\Component\Field\Model\FieldSubjectInterface;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class FieldValueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Field\Model\FieldValue');
    }

    function it_implements_Accard_subject_attribute_interface()
    {
        $this->shouldImplement('Accard\Component\Field\Model\FieldValueInterface');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_does_not_belong_to_a_subject_by_default()
    {
        $this->getSubject()->shouldReturn(null);
    }

    function it_allows_assigning_itself_to_a_subject(FieldSubjectInterface $subject)
    {
        $this->setSubject($subject);
        $this->getSubject()->shouldReturn($subject);
    }

    function it_allows_detaching_itself_from_a_subject(FieldSubjectInterface $subject)
    {
        $this->setSubject($subject);
        $this->getSubject()->shouldReturn($subject);

        $this->setSubject(null);
        $this->getSubject()->shouldReturn(null);
    }

    function it_has_no_attribute_defined_by_default()
    {
        $this->getField()->shouldReturn(null);
    }

    function its_attribute_is_definable(FieldInterface $attribute)
    {
        $this->setField($attribute);
        $this->getField()->shouldReturn($attribute);
    }

    function it_has_no_value_by_default()
    {
        $this->getValue()->shouldReturn(null);
    }

    function its_value_is_mutable()
    {
        $this->setValue('value');
        $this->getValue()->shouldReturn('value');
    }

    function it_converts_value_to_Boolean_if_attribute_has_checkbox_type(FieldInterface $attribute)
    {
        $attribute->getType()->willReturn(FieldTypes::CHECKBOX);
        $this->setField($attribute);

        $this->setValue('1');
        $this->getValue()->shouldReturn(true);

        $this->setValue(0);
        $this->getValue()->shouldReturn(false);
    }

    function it_returns_its_value_when_converted_to_string()
    {
        $this->setValue('value');
        $this->__toString()->shouldReturn('value');
    }

    function it_throws_exception_when_trying_to_get_name_without_attribute_defined()
    {
        $this
            ->shouldThrow('BadMethodCallException')
            ->duringGetName()
        ;
    }

    function it_returns_its_attribute_name(FieldInterface $attribute)
    {
        $attribute->getName()->willReturn('name');
        $this->setField($attribute);

        $this->getName()->shouldReturn('name');
    }

    function it_throws_exception_when_trying_to_get_presentation_without_attribute_defined()
    {
        $this
            ->shouldThrow('BadMethodCallException')
            ->duringGetPresentation()
        ;
    }

    function it_returns_its_attribute_presentation(FieldInterface $attribute)
    {
        $attribute->getPresentation()->willReturn('presentation');
        $this->setField($attribute);

        $this->getPresentation()->shouldReturn('presentation');
    }

    function it_throws_exception_when_trying_to_get_type_without_attribute_defined()
    {
        $this
            ->shouldThrow('BadMethodCallException')
            ->duringGetType()
        ;
    }

    function it_returns_its_attribute_type(FieldInterface $attribute)
    {
        $attribute->getType()->willReturn('type');
        $this->setField($attribute);

        $this->getType()->shouldReturn('type');
    }

    function it_throws_exception_when_trying_to_get_configuration_without_attribute_defined()
    {
        $this
            ->shouldThrow('BadMethodCallException')
            ->duringGetConfiguration()
        ;
    }

    function it_returns_its_attribute_configuration(FieldInterface $attribute)
    {
        $attribute->getConfiguration()->willReturn(array('types' => array('one')));
        $this->setField($attribute);

        $this->getConfiguration()->shouldReturn(array('types' => array('one')));
    }
}
