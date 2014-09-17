<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace spec\Accard\Bundle\ResourceBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Doctrine target entities resolver spec.
 * It adds proper method calls to doctrine listener.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DoctrineTargetEntitiesResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\ResourceBundle\DependencyInjection\DoctrineTargetEntitiesResolver');
    }

    function it_should_get_interfaces_from_the_container(ContainerBuilder $container, Definition $resolverDefinition)
    {
        $resolverDefinition->hasTag('doctrine.event_listener')
            ->shouldBeCalled()
            ->willReturn(false);

        $resolverDefinition->addTag('doctrine.event_listener', array('event' => 'loadClassMetadata'))
            ->shouldBeCalled();

        $container->hasDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->shouldBeCalled()
            ->willReturn(true);

        $container->findDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->shouldBeCalled()
            ->willReturn($resolverDefinition);

        $container->hasParameter('accard.resource.interface')
            ->shouldBeCalled()
            ->willReturn(true);

        $container->getParameter('accard.resource.interface')
            ->shouldBeCalled()
            ->willReturn('spec\Accard\Bundle\ResourceBundle\Fixture\Entity\FooInterface');

        $container->hasParameter('accard.resource.model')
            ->shouldBeCalled()
            ->willReturn(true);

        $container->getParameter('accard.resource.model')
            ->shouldBeCalled()
            ->willReturn('spec\Accard\Bundle\ResourceBundle\Fixture\Entity\Foo');

        $resolverDefinition->addMethodCall(
            'addResolveTargetEntity',
            array(
                'spec\Accard\Bundle\ResourceBundle\Fixture\Entity\FooInterface', 'spec\Accard\Bundle\ResourceBundle\Fixture\Entity\Foo', array()
            ))->shouldBeCalled();

        $this->resolve($container, array(
            'accard.resource.interface' => 'accard.resource.model'
        ));
    }

    function it_should_get_interfaces(ContainerBuilder $container, Definition $resolverDefinition)
    {
        $resolverDefinition->hasTag('doctrine.event_listener')
            ->shouldBeCalled()
            ->willReturn(false);

        $resolverDefinition->addTag('doctrine.event_listener', array('event' => 'loadClassMetadata'))
            ->shouldBeCalled();

        $container->hasDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->shouldBeCalled()
            ->willReturn(true);

        $container->findDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->shouldBeCalled()
            ->willReturn($resolverDefinition);

        $container->hasParameter('Accard\Component\Resource\Repository\RepositoryInterface')
            ->shouldBeCalled()
            ->willReturn(false);

        $container->hasParameter('spec\Accard\Bundle\ResourceBundle\Fixture\Entity\Foo')
            ->shouldBeCalled()
            ->willReturn(false);

        $resolverDefinition->addMethodCall(
            'addResolveTargetEntity',
            array(
                'Accard\Component\Resource\Repository\RepositoryInterface', 'spec\Accard\Bundle\ResourceBundle\Fixture\Entity\Foo', array()
            ))->shouldBeCalled();

        $this->resolve($container, array(
            'Accard\Component\Resource\Repository\RepositoryInterface' => 'spec\Accard\Bundle\ResourceBundle\Fixture\Entity\Foo'
        ));
    }
}
