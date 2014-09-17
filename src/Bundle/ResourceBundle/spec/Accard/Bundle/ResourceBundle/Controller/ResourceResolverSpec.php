<?php

namespace spec\Accard\Bundle\ResourceBundle\Controller;

use PhpSpec\ObjectBehavior;
use Accard\Bundle\ResourceBundle\Controller\Configuration;
use Accard\Component\Resource\Repository\RepositoryInterface;

/**
 * Resource resolver spec.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResourceResolverSpec extends ObjectBehavior
{
    function let(Configuration $configuration)
    {
        $this->beConstructedWith($configuration);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\ResourceBundle\Controller\ResourceResolver');
    }

    function it_calls_proper_method_with_arguments_based_on_configuration(
        RepositoryInterface $repository,
        $configuration
    ) {
        $configuration->getMethod('findBy')->willReturn('findAll');
        $configuration->getArguments(array())->willReturn(array(5));

        $repository->findAll(5)->shouldBeCalled()->willReturn(array('foo', 'bar'));

        $this->getResource($repository, 'findBy')->shouldReturn(array('foo', 'bar'));
    }
}
