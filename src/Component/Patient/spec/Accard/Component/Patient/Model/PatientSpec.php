<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Patient\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Accard\Component\Option\Model\OptionValueInterface;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Patient\Model\Patient');
    }

    function it_implements_Accard_patient_interface()
    {
        $this->shouldImplement('Accard\Component\Patient\Model\PatientInterface');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_MRN_by_default()
    {
        $this->getMRN()->shouldReturn(null);
    }

    function its_MRN_is_mutable()
    {
        $this->setMRN(1000000000);
        $this->getMRN()->shouldReturn(1000000000);
    }

    function it_has_no_first_name_by_default()
    {
        $this->getFirstName()->shouldReturn(null);
    }

    function its_first_name_is_mutable()
    {
        $this->setFirstName('Frank');
        $this->getFirstName()->shouldReturn('Frank');
    }

    function it_has_no_last_name_by_default()
    {
        $this->getLastName()->shouldReturn(null);
    }

    function its_last_name_is_mutable()
    {
        $this->setLastName('Bardon');
        $this->getLastName()->shouldReturn('Bardon');
    }

    function it_has_no_date_of_birth_by_default()
    {
        $this->getDateOfBirth()->shouldReturn(null);
    }

    function its_date_of_birth_is_mutable()
    {
        $date = new \DateTime();
        $this->setDateOfBirth($date);
        $this->getDateOfBirth()->shouldReturn($date);
    }

    function it_returns_null_for_age_with_no_DOB()
    {
        $this->getAge()->shouldReturn(null);
    }

    function it_can_calculate_age_for_deceased_patient()
    {
        $birth = new \DateTime('6 seconds ago');
        $death = new \DateTime('4 seconds ago');
        $this->setDateOfBirth($birth);
        $this->setDateOfDeath($death);

        $this->getAge()->shouldReturnAnInstanceOf('DateInterval');
    }

    function it_can_calculate_age_for_living_patient()
    {
        $birth = new \DateTime('6 seconds ago');
        $this->setDateOfBirth($birth);

        $this->getAge()->shouldReturnAnInstanceOf('DateInterval');
    }

    function it_has_no_date_of_death_by_default()
    {
        $this->getDateOfDeath()->shouldReturn(null);
    }

    function its_date_of_death_is_mutable()
    {
        $date = new \DateTime();
        $this->setDateOfDeath($date);
        $this->getDateOfDeath()->shouldReturn($date);
    }

    function is_not_deceased_if_date_of_death_is_not_set()
    {
        $this->isDeceased()->shouldReturn(false);
    }

    function is_not_deceased_if_date_of_death_is_in_future()
    {
        $date = new \DateTime('tomorrow');
        $this->setDateOfDeath($date);
        $this->isDeceased()->shouldReturn(false);
    }

    function is_deceased_if_date_of_death_is_set()
    {
        $date = new \DateTime('yesterday');
        $this->setDateOfDeath($date);
        $this->isDeceased()->shouldReturn(true);
    }

    function it_has_no_gender_by_default()
    {
        $this->getGender()->shouldReturn(null);
    }

    function its_gender_is_mutable(OptionValueInterface $gender)
    {
        $this->setGender($gender);
        $this->getGender()->shouldReturn($gender);
    }

    function it_has_fluent_interface(OptionValueInterface $gender)
    {
        $date = new \DateTime();

        $this->setMRN(1000000000)->shouldReturn($this);
        $this->setFirstName('Frank')->shouldReturn($this);
        $this->setLastName('Bardon')->shouldReturn($this);
        $this->setDateOfBirth($date)->shouldReturn($this);
        $this->setDateOfDeath($date)->shouldReturn($this);
        $this->setGender($gender)->shouldReturn($this);
    }
}
