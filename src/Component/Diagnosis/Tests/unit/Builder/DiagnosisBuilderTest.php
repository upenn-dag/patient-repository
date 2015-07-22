<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Diagnosis\Builder;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Diagnosis\Builder\DiagnosisBuilder;

/**
 * Diagnosis builder tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisBuilderTest extends Test
{
    protected function _before()
    {
        $this->diagnosis = Mockery::mock('Accard\Component\Diagnosis\Model\DiagnosisInterface');
        $this->field = Mockery::mock('Accard\Component\Diagnosis\Model\FieldInterface');
        $this->fieldValue = Mockery::mock('Accard\Component\Diagnosis\Model\FieldValueInterface');

        $this->objectManager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager')
            ->shouldReceive('persist')->zeroOrMoreTimes()
            ->shouldReceive('flush')->zeroOrMoreTimes()
            ->getMock();
        $this->diagnosisRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');
        $this->fieldRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');
        $this->fieldValueRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');

        $this->builder = new DiagnosisBuilder($this->objectManager, $this->diagnosisRepository, $this->fieldRepository, $this->fieldValueRepository);
    }

    public function testDiagnosisBuilderCanReturnDiagnosisRepository()
    {
        $this->assertSame($this->diagnosisRepository, $this->builder->getRepository());
    }

    public function testDiagnosisBuilderCanReturnFieldRepository()
    {
        $this->assertSame($this->fieldRepository, $this->builder->getFieldRepository());
    }

    public function testDiagnosisBuilderCanReturnFieldValueRepository()
    {
        $this->assertSame($this->fieldValueRepository, $this->builder->getFieldValueRepository());
    }

    public function testDiagnosisBuilderCanCreateNewDiagnosisResource()
    {
        $this->enableDiagnosisCreate();
        $this->builder->create();
        $this->assertAttributeSame($this->diagnosis, 'resource', $this->builder);
    }

    public function testDiagnosisBuilderCreateIsFluent()
    {
        $this->enableDiagnosisCreate();
        $this->assertSame($this->builder->create(), $this->builder);
    }

    public function testDiagnosisBuilderCanAddFieldWithoutPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, true);
        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testDiagnosisBuilderCanAddFieldWithoutPresentationWithDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(true, true);
        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testDiagnosisBuilderCanAddFieldWithPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, false);
        $this->builder->addField('NAME', 'VALUE', 'PRESENTATION');
    }

    public function testDiagnosisBuilderAddFieldIsFluent()
    {
        $this->setupFieldAdditionScenario(true, true);
        $this->assertSame($this->builder, $this->builder->addField('NAME', 'VALUE', null));
    }


    // Privates

    private function enableDiagnosisCreate()
    {
        $this->diagnosisRepository->shouldReceive('createNew')->once()->andReturn($this->diagnosis);
    }

    private function setupFieldAdditionScenario($findInDb, $presentationIsNull)
    {
        $this->enableDiagnosisCreate();
        $this->builder->create();

        $this->diagnosis->shouldReceive('addField')->zeroOrMoreTimes()->andReturn(Mockery::self());
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
