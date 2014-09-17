<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Patient\Builder;

use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Resource\Repository\RepositoryInterface;
use Accard\Component\Patient\Model\PatientInterface;
use Accard\Component\Patient\Model\FieldInterface;
use Accard\Component\Patient\Model\FieldValueInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientBuilderSpec extends ObjectBehavior
{
    function let(PatientInterface $patient,
                 ObjectManager $manager,
                 RepositoryInterface $patientRepository,
                 RepositoryInterface $fieldRepository,
                 RepositoryInterface $fieldValueRepository)
    {
        $this->beConstructedWith(
            $manager,
            $patientRepository,
            $fieldRepository,
            $fieldValueRepository
        );

        $patientRepository->createNew()->willReturn($patient);
        $this->create()->shouldReturn($this);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Patient\Builder\PatientBuilder');
    }

    function it_implements_Accard_patient_builder_interface()
    {
        $this->shouldImplement('Accard\Component\Patient\Builder\PatientBuilderInterface');
    }

    function it_implements_Accard_builder_interface()
    {
        $this->shouldImplement('Accard\Component\Resource\Builder\BuilderInterface');
    }

    function it_creates_new_patient($patientRepository)
    {
        $patientRepository->createNew()->shouldBeCalled();
        $this->create();
    }

    function its_patient_is_accessible_after_creation($patient)
    {
        $this->create();
        $this->get()->shouldReturn($patient);
    }

    function its_patient_is_mutable($patient)
    {
        $this->set($patient);
        $this->get()->shouldReturn($patient);
    }

    function it_is_savable_and_flushes_by_default($manager, $patient)
    {
        $manager->persist($patient)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->set($patient);
        $this->save();
    }

    function it_is_savable_and_can_be_made_to_not_flush($manager, $patient)
    {
        $manager->persist($patient)->shouldBeCalled();
        $manager->flush()->shouldNotBeCalled();

        $this->set($patient);
        $this->save(false);
    }

    function it_proxies_undefined_methods_to_patient($patient)
    {
        $patient->setFirstName('Frank')->shouldBeCalled();
        $patient->setLastName('Bardon')->shouldBeCalled();

        $this->set($patient);
        $this->setFirstName('Frank');
        $this->setLastName('Bardon');
    }

    function it_throws_method_exception_if_method_not_found_on_patient($patient)
    {
        $this->set($patient);
        $this->shouldThrow('BadMethodCallException')->during('setUndefinedMethod', array(0));
    }

    function it_adds_field_value_if_field_already_exists($fieldRepository,
                                                         $fieldValueRepository,
                                                         $patient,
                                                         FieldInterface $field,
                                                         FieldValueInterface $fieldValue)
    {
        $fieldRepository->findOneBy(array('name' => 'name'))->shouldBeCalled()->willReturn($field);
        $fieldValueRepository->createNew()->shouldBeCalled()->willReturn($fieldValue);

        $fieldValue->setField($field)->shouldBeCalled();
        $fieldValue->setValue('value')->shouldBeCalled();

        $patient->addField($fieldValue)->shouldBeCalled();

        $this->addField('name', 'value')->shouldReturn($this);
    }

    function it_creates_field_if_it_does_not_exist($fieldRepository,
                                                   $fieldValueRepository,
                                                   $manager,
                                                   $patient,
                                                   FieldInterface $field,
                                                   FieldValueInterface $fieldValue)
    {
        $fieldRepository->findOneBy(array('name' => 'name'))->shouldBeCalled()->willReturn(null);
        $fieldRepository->createNew()->shouldBeCalled()->willReturn($field);

        $field->setName('name')->shouldBeCalled();
        $field->setPresentation('name')->shouldBeCalled();

        $manager->persist($field)->shouldBeCalled();
        $manager->flush($field)->shouldBeCalled();

        $fieldValueRepository->createNew()->shouldBeCalled()->willReturn($fieldValue);

        $fieldValue->setField($field)->shouldBeCalled();
        $fieldValue->setValue('value')->shouldBeCalled();

        $patient->addField($fieldValue)->shouldBeCalled();

        $this->addField('name', 'value')->shouldReturn($this);
    }
}
