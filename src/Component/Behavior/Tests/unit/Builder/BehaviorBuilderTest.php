<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Behavior\Builder;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Behavior\Builder\BehaviorBuilder;

/**
 * Behavior builder tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BehaviorBuilderTest extends Test
{
    protected function _before()
    {
        $this->attribute = Mockery::mock('Accard\Component\Behavior\Model\BehaviorInterface');
        $this->field = Mockery::mock('Accard\Component\Behavior\Model\FieldInterface');
        $this->fieldValue = Mockery::mock('Accard\Component\Behavior\Model\FieldValueInterface');

        $this->objectManager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager')
            ->shouldReceive('persist')->zeroOrMoreTimes()
            ->shouldReceive('flush')->zeroOrMoreTimes()
            ->getMock();
        $this->attributeRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');
        $this->fieldRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');
        $this->fieldValueRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');

        $this->builder = new BehaviorBuilder($this->objectManager, $this->attributeRepository, $this->fieldRepository, $this->fieldValueRepository);
    }

    public function testBehaviorBuilderCanReturnFieldRepository()
    {
        $this->assertSame($this->fieldRepository, $this->builder->getFieldRepository());
    }

    public function testBehaviorBuilderCanReturnFieldValueRepository()
    {
        $this->assertSame($this->fieldValueRepository, $this->builder->getFieldValueRepository());
    }

    public function testBehaviorBuilderCanCreateNewBehaviorResource()
    {
        $this->enableBehaviorCreate();
        $this->builder->create();
        $this->assertAttributeSame($this->attribute, 'resource', $this->builder);
    }

    public function testBehaviorBuilderCreateIsFluent()
    {
        $this->enableBehaviorCreate();
        $this->assertSame($this->builder->create(), $this->builder);
    }

    public function testBehaviorBuilderCanAddFieldWithoutPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, true);
        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testBehaviorBuilderCanAddFieldWithoutPresentationWithDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(true, true);
        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testBehaviorBuilderCanAddFieldWithPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, false);
        $this->builder->addField('NAME', 'VALUE', 'PRESENTATION');
    }

    public function testBehaviorBuilderAddFieldIsFluent()
    {
        $this->setupFieldAdditionScenario(true, true);
        $this->assertSame($this->builder, $this->builder->addField('NAME', 'VALUE', null));
    }


    // Privates

    private function enableBehaviorCreate()
    {
        $this->attributeRepository->shouldReceive('createNew')->once()->andReturn($this->attribute);
    }

    private function setupFieldAdditionScenario($findInDb, $presentationIsNull)
    {
        $this->enableBehaviorCreate();
        $this->builder->create();

        $this->attribute->shouldReceive('addField')->zeroOrMoreTimes()->andReturn(Mockery::self());
        $this->fieldValueRepository->shouldReceive('createNew')->once()->andReturn($this->fieldValue);
        $this->fieldValue->shouldReceive('setField')->once()->with($this->field)->andReturn(Mockery::self());

        if ($findInDb) {
            $this->fieldRepository->shouldReceive('findOneBy')->once()->andReturn($this->field);
        } else {
            $this->fieldRepository->shouldReceive('findOneBy')->once()->andReturn(null);
            $this->fieldRepository->shouldReceive('createNew')->once()->andReturn($this->field);
            $this->field->shouldReceive('setName')->once()->with('NAME')->andReturn(Mockery::self());
            if ($presentationIsNull) {
                $this->field->shouldReceive('setPresentation')->once()->with('NAME')->andReturn(Mockery::self());
            } else {
                $this->field->shouldReceive('setPresentation')->once()->with('PRESENTATION')->andReturn(Mockery::self());
            }

        }
    }
}
