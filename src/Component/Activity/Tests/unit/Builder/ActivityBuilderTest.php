<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Activity\Builder;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Activity\Builder\ActivityBuilder;

/**
 * Activity builder tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityBuilderTest extends Test
{
    protected function _before()
    {
        $this->activity = Mockery::mock('Accard\Component\Activity\Model\ActivityInterface');
        $this->field = Mockery::mock('Accard\Component\Activity\Model\FieldInterface');
        $this->fieldValue = Mockery::mock('Accard\Component\Activity\Model\FieldValueInterface');

        $this->objectManager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager')
            ->shouldReceive('persist')->zeroOrMoreTimes()
            ->shouldReceive('flush')->zeroOrMoreTimes()
            ->getMock();
        $this->activityRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');
        $this->fieldRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');
        $this->fieldValueRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');

        $this->builder = new ActivityBuilder($this->objectManager, $this->activityRepository, $this->fieldRepository, $this->fieldValueRepository);
    }

    public function testActivityBuilderCanReturnFieldRepository()
    {
        $this->assertSame($this->fieldRepository, $this->builder->getFieldRepository());
    }

    public function testActivityBuilderCanReturnFieldValueRepository()
    {
        $this->assertSame($this->fieldValueRepository, $this->builder->getFieldValueRepository());
    }

    public function testActivityBuilderCanCreateNewActivityResource()
    {
        $this->enableActivityCreate();
        $this->builder->create();
        $this->assertAttributeSame($this->activity, 'resource', $this->builder);
    }

    public function testActivityBuilderCreateIsFluent()
    {
        $this->enableActivityCreate();
        $this->assertSame($this->builder->create(), $this->builder);
    }

    public function testActivityBuilderCanAddFieldWithoutPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, true);
        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testActivityBuilderCanAddFieldWithoutPresentationWithDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(true, true);
        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testActivityBuilderCanAddFieldWithPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, false);
        $this->builder->addField('NAME', 'VALUE', 'PRESENTATION');
    }

    public function testActivityBuilderAddFieldIsFluent()
    {
        $this->setupFieldAdditionScenario(true, true);
        $this->assertSame($this->builder, $this->builder->addField('NAME', 'VALUE', null));
    }


    // Privates

    private function enableActivityCreate()
    {
        $this->activityRepository->shouldReceive('createNew')->once()->andReturn($this->activity);
    }

    private function setupFieldAdditionScenario($findInDb, $presentationIsNull)
    {
        $this->enableActivityCreate();
        $this->builder->create();

        $this->activity->shouldReceive('addField')->zeroOrMoreTimes()->andReturn(Mockery::self());
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
