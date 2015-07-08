<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Resource\Builder;

use stdClass;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Resource\Test\Stub\Builder;
use Accard\Component\Resource\Test\Stub\Resource;

/**
 * Abstract builder tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AbstractBuilderTest extends Test
{
    public function _before()
    {
        $this->resource = new Resource();
        $this->manager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $this->builder = new Builder($this->manager);
    }

    public function testBuilderImplementsInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Builder\BuilderInterface',
            $this->builder
        );
    }

    public function testBuilderResourceIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'resource', $this->builder);
        $this->assertNull($this->builder->get());
    }

    public function testBuilderResourceIsMutable()
    {
        $this->builder->set($this->resource);
        $this->assertAttributeSame($this->resource, 'resource', $this->builder);
        $this->assertSame($this->resource, $this->builder->get());
    }

    public function tesTBuilderResourceSetFluency()
    {
        $this->assertSame($this->builder, $this->builder->save());
    }

    public function testBuilderIsSavableWithDefaultFlush()
    {
        $this->enablePersistence(true);
        $this->builder->set($this->resource);
        $this->builder->save();
    }

    public function testBuilderIsSavableWithExplicitFlush()
    {
        $this->enablePersistence(true);
        $this->builder->set($this->resource);
        $this->builder->save(true);
    }

    public function testBuilderIsSavableWithoutFlush()
    {
        $this->enablePersistence(false);
        $this->builder->set($this->resource);
        $this->builder->save(false);
    }

    public function testBuilderSaveReturnsResource()
    {
        $this->enablePersistence(true);
        $this->builder->set($this->resource);
        $this->assertSame($this->resource, $this->builder->save());
    }

    public function testBuilderPassesMethodsToResource()
    {
        $this->builder->set($this->resource);
        $this->builder->setTest('TEST');

        // If set test was called it will contain 'TEST'.
        $this->assertAttributeSame('TEST', 'test', $this->resource);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testBuilderThrowsWhenNoResourceProvided()
    {
        $this->builder->setFail('FAIL');
    }

    public function testBuilderMethodPassthruFluency()
    {
        $this->builder->set($this->resource);
        $this->assertSame($this->builder, $this->builder->setTest('TEST'));
    }

    // Privates

    /**
     * Handles mock assertions for save() tests.
     */
    private function enablePersistence($flushing)
    {
        $this->manager->shouldReceive('persist')->with($this->resource)->once();

        if ($flushing) {
            $this->manager->shouldReceive('flush')->once();
        }
    }
}
