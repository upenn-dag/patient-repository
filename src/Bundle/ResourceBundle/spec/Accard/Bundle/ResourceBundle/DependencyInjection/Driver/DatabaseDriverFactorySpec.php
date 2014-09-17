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
use Accard\Bundle\ResourceBundle\AccardResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DatabaseDriverFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\ResourceBundle\DependencyInjection\Driver\DatabaseDriverFactory');
    }

    function it_should_create_a_orm_driver_by_default(ContainerBuilder $container)
    {
        $this::get(AccardResourceBundle::DRIVER_DOCTRINE_ORM, $container, 'prefix', 'resource')
            ->shouldhaveType('Accard\Bundle\ResourceBundle\DependencyInjection\Driver\DoctrineORMDriver');
    }

    function it_should_create_a_orm_driver(ContainerBuilder $container)
    {
        $this::get(AccardResourceBundle::DRIVER_DOCTRINE_ORM, $container, 'prefix', 'resource')
            ->shouldhaveType('Accard\Bundle\ResourceBundle\DependencyInjection\Driver\DoctrineORMDriver');
    }
}
