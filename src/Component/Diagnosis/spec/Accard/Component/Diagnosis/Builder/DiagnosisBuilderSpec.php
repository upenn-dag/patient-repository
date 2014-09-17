<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Diagnosis\Builder;

use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Resource\Repository\RepositoryInterface;
use Accard\Component\Diagnosis\Model\Diagnosis;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use DateTime;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisBuilderSpec extends ObjectBehavior
{
    function let(ObjectManager $manager,
                 RepositoryInterface $diagnosisRepository,
                 RepositoryInterface $fieldRepository,
                 RepositoryInterface $fieldValueRepository,
                 Diagnosis $diagnosis)
    {
        $diagnosisRepository->createNew()->willReturn($diagnosis);

        $this->beConstructedWith($manager, $diagnosisRepository, $fieldRepository, $fieldValueRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Diagnosis\Builder\DiagnosisBuilder');
    }

    function it_implements_Accard_diagnosis_builder_interface()
    {
        $this->shouldImplement('Accard\Component\Diagnosis\Builder\DiagnosisBuilderInterface');
    }

    function it_implements_Accard_builder_interface()
    {
        $this->shouldImplement('Accard\Component\Resource\Builder\BuilderInterface');
    }

    function it_creates_new_diagnosis($diagnosisRepository)
    {
        $diagnosisRepository->createNew()->shouldBeCalled();
        $this->create();
    }

    function its_diagnosis_is_accessible_after_creation($diagnosis)
    {
        $this->create();
        $this->get()->shouldReturn($diagnosis);
    }

    function its_diagnosis_is_mutable($diagnosis)
    {
        $this->set($diagnosis);
        $this->get()->shouldReturn($diagnosis);
    }

    function it_is_savable_and_flushes_by_default($manager, $diagnosis)
    {
        $manager->persist($diagnosis)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->set($diagnosis);
        $this->save();
    }

    function it_is_savable_and_can_be_made_to_not_flush($manager, $diagnosis)
    {
        $manager->persist($diagnosis)->shouldBeCalled();
        $manager->flush()->shouldNotBeCalled();

        $this->set($diagnosis);
        $this->save(false);
    }

    function it_can_access_diagnosis_methods_via_passthrough($diagnosis)
    {
    	$date = new DateTime();
        $diagnosis->setStartDate($date)->shouldBeCalled();

        $this->set($diagnosis);
        $this->setStartDate($date);
    }

    function it_throws_method_exception_if_method_not_found_on_diagnosis($diagnosis)
    {
        $this->set($diagnosis);
        $this->shouldThrow('BadMethodCallException')->during('setUndefinedMethod', array(0));
    }

    function it_has_fluent_interface($diagnosis)
    {
    	$date = new DateTime();
        $diagnosis->setStartDate($date)->willReturn($diagnosis);

        $this->create()->shouldReturn($this);
        $this->setStartDate($date)->shouldReturn($this);
    }
}
