<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Prototype\Provider;

use Mockery;
use Accard\Component\Prototype\Provider\PrototypeProvider;

/**
 * Prototype provider tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PrototypeProviderTest extends \Codeception\TestCase\Test
{
    public function testPrototypeProviderProvidesPrototypes()
    {
        $repository = Mockery::mock('Accard\Component\Prototype\Repository\PrototypeRepositoryInterface')
            ->shouldReceive('getPrototypes')->once()->andReturn(array())
            ->getMock();

        $provider = new PrototypeProvider($repository);
        $this->assertSame(array(), $provider->getPrototypes());
    }

    public function testPrototypeProviderProvidesModelClass()
    {
        $repository = Mockery::mock('Accard\Component\Prototype\Repository\PrototypeRepositoryInterface')
            ->shouldReceive('getClassName')->once()->andReturn('CLASS')
            ->getMock();

        $provider = new PrototypeProvider($repository);
        $this->assertSame('CLASS', $provider->getPrototypeModelClass());
    }

    /**
     * @expectedException Accard\Component\Prototype\Exception\PrototypeNotFoundException
     */
    public function testPrototypeProviderThrowsIfPrototypeNotFoundById()
    {
        $repository = Mockery::mock('Accard\Component\Prototype\Repository\PrototypeRepositoryInterface')
            ->shouldReceive('getPrototype')->once()->andReturn(null)
            ->getMock();

        $provider = new PrototypeProvider($repository);
        $provider->getPrototype(1);
    }

    public function testPrototypeProviderProvidesPrototypeById()
    {
        $repository = Mockery::mock('Accard\Component\Prototype\Repository\PrototypeRepositoryInterface')
            ->shouldReceive('getPrototype')->once()->andReturn('FIELD')
            ->getMock();

        $provider = new PrototypeProvider($repository);
        $this->assertSame('FIELD', $provider->getPrototype(1));
    }

    public function testPrototypeProviderDetectsPrototypesByIdWhenPresent()
    {
        $repository = Mockery::mock('Accard\Component\Prototype\Repository\PrototypeRepositoryInterface')
            ->shouldReceive('getPrototype')->once()->andReturn('FIELD')
            ->getMock();

        $provider = new PrototypeProvider($repository);
        $this->assertTrue($provider->hasPrototype(1));
    }

    public function testPrototypeProviderDoesNotDetectPrototypesByIdWhenNotPresent()
    {
        $repository = Mockery::mock('Accard\Component\Prototype\Repository\PrototypeRepositoryInterface')
            ->shouldReceive('getPrototype')->once()->andReturn(null)
            ->getMock();

        $provider = new PrototypeProvider($repository);
        $this->assertFalse($provider->hasPrototype(1));
    }

    /**
     * @expectedException Accard\Component\Prototype\Exception\PrototypeNotFoundException
     */
    public function testPrototypeProviderThrowsIfPrototypeNotFoundByName()
    {
        $repository = Mockery::mock('Accard\Component\Prototype\Repository\PrototypeRepositoryInterface')
            ->shouldReceive('getPrototypeByName')->once()->andReturn(null)
            ->getMock();

        $provider = new PrototypeProvider($repository);
        $provider->getPrototypeByName('NAME');
    }

    public function testPrototypeProviderProvidesPrototypeByName()
    {
        $repository = Mockery::mock('Accard\Component\Prototype\Repository\PrototypeRepositoryInterface')
            ->shouldReceive('getPrototypeByName')->once()->andReturn('FIELD')
            ->getMock();

        $provider = new PrototypeProvider($repository);
        $this->assertSame('FIELD', $provider->getPrototypeByName('NAME'));
    }

    public function testPrototypeProviderDetectsPrototypesByNameWhenPresent()
    {
        $repository = Mockery::mock('Accard\Component\Prototype\Repository\PrototypeRepositoryInterface')
            ->shouldReceive('getPrototypeByName')->once()->andReturn('FIELD')
            ->getMock();

        $provider = new PrototypeProvider($repository);
        $this->assertTrue($provider->hasPrototypeByName('NAME'));
    }

    public function testPrototypeProviderDoesNotDetectPrototypesByNameWhenNotPresent()
    {
        $repository = Mockery::mock('Accard\Component\Prototype\Repository\PrototypeRepositoryInterface')
            ->shouldReceive('getPrototypeByName')->once()->andReturn(null)
            ->getMock();

        $provider = new PrototypeProvider($repository);
        $this->assertFalse($provider->hasPrototypeByName('NAME'));
    }
}
