<?php


/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Activity;

use Mockery;
use Codeception\TestCase\Test;

/**
 * Tests for presence of activity interfaces required by the API.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class InterfaceTest extends Test
{
    public function testActivityBuilderInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Activity\Builder\ActivityBuilderInterface'));
    }

    public function testActivityExceptionInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Activity\Exception\ActivityException'));
    }

    public function testActivityFieldInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Activity\Model\FieldInterface'));
    }

    public function testActivityFieldValueInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Activity\Model\FieldValueInterface'));
    }

    public function testActivityModelInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Activity\Model\ActivityInterface'));
    }

    public function testActivityProviderInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Activity\Provider\ActivityProviderInterface'));
    }

    public function testActivityRepositoryInterfaceExists()
    {
        $this->assertTrue(interface_exists('Accard\Component\Activity\Repository\ActivityRepositoryInterface'));
    }
}
