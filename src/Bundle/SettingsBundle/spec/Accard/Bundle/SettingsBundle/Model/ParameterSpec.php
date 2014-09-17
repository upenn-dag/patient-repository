<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Bundle\SettingsBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ParameterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\SettingsBundle\Model\Parameter');
    }

    function it_implements_Accard_patient_interface()
    {
        $this->shouldImplement('Accard\Bundle\SettingsBundle\Model\ParameterInterface');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_namespace_by_default()
    {
        $this->getNamespace()->shouldReturn(null);
    }

    function its_namespace_is_mutable()
    {
        $this->setNamespace('namespace');
        $this->getNamespace()->shouldReturn('namespace');
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

    function it_has_no_value_by_default()
    {
    	$this->getValue()->shouldReturn(null);
    }

    function its_value_is_mutable()
    {
    	$this->setValue('value');
    	$this->getValue()->shouldReturn('value');
    }

    function it_has_fluent_interface()
    {
        $this->setNamespace('namespace')->shouldReturn($this);
        $this->setName('name')->shouldReturn($this);
        $this->setValue('value')->shouldReturn($this);
    }
}
