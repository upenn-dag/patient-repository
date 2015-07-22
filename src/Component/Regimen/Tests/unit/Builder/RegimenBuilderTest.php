<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Regimen\Builder;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Regimen\Builder\RegimenBuilder;

/**
 * Regimen builder tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenBuilderTest extends Test
{
    protected function _before()
    {
        $this->regimen = Mockery::mock('Accard\Component\Regimen\Model\RegimenInterface');
        $this->field = Mockery::mock('Accard\Component\Regimen\Model\FieldInterface');
        $this->fieldValue = Mockery::mock('Accard\Component\Regimen\Model\FieldValueInterface');

        $this->objectManager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager')
            ->shouldReceive('persist')->zeroOrMoreTimes()
            ->shouldReceive('flush')->zeroOrMoreTimes()
            ->getMock();
        $this->regimenRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');
        $this->fieldRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');
        $this->fieldValueRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');

        $this->builder = new RegimenBuilder($this->objectManager, $this->regimenRepository, $this->fieldRepository, $this->fieldValueRepository);
    }

    public function testRegimenBuilderCanReturnFieldRepository()
    {
        $this->assertSame($this->fieldRepository, $this->builder->getFieldRepository());
    }

    public function testRegimenBuilderCanReturnFieldValueRepository()
    {
        $this->assertSame($this->fieldValueRepository, $this->builder->getFieldValueRepository());
    }

    public function testRegimenBuilderCanCreateNewRegimenResource()
    {
        $this->enableRegimenCreate();
        $this->builder->create();
        $this->assertAttributeSame($this->regimen, 'resource', $this->builder);
    }

    public function testRegimenBuilderCreateIsFluent()
    {
        $this->enableRegimenCreate();
        $this->assertSame($this->builder->create(), $this->builder);
    }

    public function testRegimenBuilderCanAddFieldWithoutPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, true);
        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testRegimenBuilderCanAddFieldWithoutPresentationWithDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(true, true);
        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testRegimenBuilderCanAddFieldWithPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, false);
        $this->builder->addField('NAME', 'VALUE', 'PRESENTATION');
    }

    public function testRegimenBuilderAddFieldIsFluent()
    {
        $this->setupFieldAdditionScenario(true, true);
        $this->assertSame($this->builder, $this->builder->addField('NAME', 'VALUE', null));
    }


    // Privates

    private function enableRegimenCreate()
    {
        $this->regimenRepository->shouldReceive('createNew')->once()->andReturn($this->regimen);
    }

    private function setupFieldAdditionScenario($findInDb, $presentationIsNull)
    {
        $this->enableRegimenCreate();
        $this->builder->create();

        $this->regimen->shouldReceive('addField')->zeroOrMoreTimes()->andReturn(Mockery::self());
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
