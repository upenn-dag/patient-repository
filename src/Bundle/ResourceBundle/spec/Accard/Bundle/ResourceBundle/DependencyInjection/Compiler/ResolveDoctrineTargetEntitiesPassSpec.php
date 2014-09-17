<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace spec\Accard\Bundle\ResourceBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Compiler pass which resolves interfaces into target entity names during
 * compile time of container.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResolveDoctrineTargetEntitiesPassSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('accard_resource', array());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(
            'Accard\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass'
        );
    }

    function it_is_a_compiler_pass()
    {
        $this->shouldImplement('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    function it_should_resolve_entities(ContainerBuilder $container, Definition $resolverDefinition)
    {
        $container->getParameter('accard_resource.driver')
            ->shouldBeCalled()
            ->willReturn('doctrine/orm');

        $container->hasDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->shouldBeCalled()
            ->willReturn(true);

        $container->findDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->shouldBeCalled()
            ->willReturn($resolverDefinition);

        $this->process($container);
    }
}
