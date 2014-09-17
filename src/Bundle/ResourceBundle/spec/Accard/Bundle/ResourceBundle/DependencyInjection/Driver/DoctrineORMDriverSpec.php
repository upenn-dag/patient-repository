<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace spec\Accard\Bundle\ResourceBundle\DependencyInjection\Driver;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DoctrineORMDriverSpec extends ObjectBehavior
{
    function let(ContainerBuilder $container)
    {
        $this->beConstructedWith($container, 'prefix', 'resource');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\ResourceBundle\DependencyInjection\Driver\DoctrineORMDriver');
    }

    function it_should_implement_database_interface()
    {
        $this->shouldHaveType('Accard\Bundle\ResourceBundle\DependencyInjection\Driver\DatabaseDriverInterface');
    }

    function it_should_create_definition(ContainerBuilder $container)
    {
        $container->hasParameter("prefix.repository.resource.class")->shouldBeCalled();

        $container->setDefinition(
            'prefix.controller.resource',
            Argument::type('Symfony\Component\DependencyInjection\Definition')
        )->shouldBeCalled();

        $container->setDefinition(
            'prefix.repository.resource',
            Argument::type('Symfony\Component\DependencyInjection\Definition')
        )->shouldBeCalled();

        $container->setAlias(
            'prefix.manager.resource',
            Argument::type('Symfony\Component\DependencyInjection\Alias')
        )->shouldBeCalled();

        $this->beConstructedWith($container, 'prefix', 'resource');

        $this->load(array(
            'model' => 'Accard\Model',
            'controller' => 'Accard\Controller',
            'repository' => 'Accard\Repository',
        ));
    }

    function it_should_create_definition_and_get_repository_in_container(ContainerBuilder $container)
    {
        $container->hasParameter("prefix.repository.resource.class")
            ->willReturn(true)
            ->shouldBeCalled();

        $container->getParameter("prefix.repository.resource.class")
            ->shouldBeCalled();

        $container->setDefinition(
            'prefix.controller.resource',
            Argument::type('Symfony\Component\DependencyInjection\Definition')
        )->shouldBeCalled();

        $container->setDefinition(
            'prefix.repository.resource',
            Argument::type('Symfony\Component\DependencyInjection\Definition')
        )->shouldBeCalled();

        $container->setAlias(
            'prefix.manager.resource',
            Argument::type('Symfony\Component\DependencyInjection\Alias')
        )->shouldBeCalled();

        $this->beConstructedWith($container, 'prefix', 'resource');

        $this->load(array(
            'model' => 'Accard\Model',
            'controller' => 'Accard\Controller',
            'repository' => 'Accard\Repository',
        ));
    }
}
