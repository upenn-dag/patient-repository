<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Provider;

use Mockery;
use Accard\Component\Field\Provider\FieldProvider;

/**
 * Field provider tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldProviderTest extends \Codeception\TestCase\Test
{
    public function testFieldProviderProvidesFields()
    {
        $repository = Mockery::mock('Accard\Component\Field\Repository\FieldRepositoryInterface')
            ->shouldReceive('findAll')->once()->andReturn(array())
            ->getMock();

        $provider = new FieldProvider($repository);
        $this->assertSame(array(), $provider->getFields());
    }

    public function testFieldProviderProvidesModelClass()
    {
        $repository = Mockery::mock('Accard\Component\Field\Repository\FieldRepositoryInterface')
            ->shouldReceive('getClassName')->once()->andReturn('CLASS')
            ->getMock();

        $provider = new FieldProvider($repository);
        $this->assertSame('CLASS', $provider->getFieldModelClass());
    }

    /**
     * @expectedException Accard\Component\Field\Exception\FieldNotFoundException
     */
    public function testFieldProviderThrowsIfFieldNotFoundById()
    {
        $repository = Mockery::mock('Accard\Component\Field\Repository\FieldRepositoryInterface')
            ->shouldReceive('find')->once()->andReturn(null)
            ->getMock();

        $provider = new FieldProvider($repository);
        $provider->getField(1);
    }

    public function testFieldProviderProvidesFieldById()
    {
        $repository = Mockery::mock('Accard\Component\Field\Repository\FieldRepositoryInterface')
            ->shouldReceive('find')->once()->andReturn('FIELD')
            ->getMock();

        $provider = new FieldProvider($repository);
        $this->assertSame('FIELD', $provider->getField(1));
    }

    public function testFieldProviderDetectsFieldsByIdWhenPresent()
    {
        $repository = Mockery::mock('Accard\Component\Field\Repository\FieldRepositoryInterface')
            ->shouldReceive('find')->once()->andReturn('FIELD')
            ->getMock();

        $provider = new FieldProvider($repository);
        $this->assertTrue($provider->hasField(1));
    }

    public function testFieldProviderDoesNotDetectFieldsByIdWhenNotPresent()
    {
        $repository = Mockery::mock('Accard\Component\Field\Repository\FieldRepositoryInterface')
            ->shouldReceive('find')->once()->andReturn(null)
            ->getMock();

        $provider = new FieldProvider($repository);
        $this->assertFalse($provider->hasField(1));
    }

    /**
     * @expectedException Accard\Component\Field\Exception\FieldNotFoundException
     */
    public function testFieldProviderThrowsIfFieldNotFoundByName()
    {
        $repository = Mockery::mock('Accard\Component\Field\Repository\FieldRepositoryInterface')
            ->shouldReceive('findOneByName')->once()->andReturn(null)
            ->getMock();

        $provider = new FieldProvider($repository);
        $provider->getFieldByName('NAME');
    }

    public function testFieldProviderProvidesFieldByName()
    {
        $repository = Mockery::mock('Accard\Component\Field\Repository\FieldRepositoryInterface')
            ->shouldReceive('findOneByName')->once()->andReturn('FIELD')
            ->getMock();

        $provider = new FieldProvider($repository);
        $this->assertSame('FIELD', $provider->getFieldByName('NAME'));
    }

    public function testFieldProviderDetectsFieldsByNameWhenPresent()
    {
        $repository = Mockery::mock('Accard\Component\Field\Repository\FieldRepositoryInterface')
            ->shouldReceive('findOneByName')->once()->andReturn('FIELD')
            ->getMock();

        $provider = new FieldProvider($repository);
        $this->assertTrue($provider->hasFieldByName('NAME'));
    }

    public function testFieldProviderDoesNotDetectFieldsByNameWhenNotPresent()
    {
        $repository = Mockery::mock('Accard\Component\Field\Repository\FieldRepositoryInterface')
            ->shouldReceive('findOneByName')->once()->andReturn(null)
            ->getMock();

        $provider = new FieldProvider($repository);
        $this->assertFalse($provider->hasFieldByName('NAME'));
    }
}
