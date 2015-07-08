<?php

namespace AccardTest\Component\Patient\Builder;

use Codeception\TestCase\Test;
use Accard\Component\Patient\Builder\PatientBuilder;
use Accard\Component\Field\Model\FieldTypes;
use Mockery;

class PatientBuilderTest extends Test
{
    protected function _before()
    {
        $this->patient = Mockery::mock('Accard\Component\Patient\Model\PatientInterface');
        $this->field = Mockery::mock('Accard\Component\Patient\Model\FieldInterface');
        $this->fieldValue = Mockery::mock('Accard\Component\Patient\Model\FieldValueInterface');

        $this->objectManager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager')
            ->shouldReceive('persist')->zeroOrMoreTimes()
            ->shouldReceive('flush')->zeroOrMoreTimes()
            ->getMock();
        $this->patientRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');
        $this->fieldRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');
        $this->fieldValueRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');

        $this->builder = new PatientBuilder($this->objectManager, $this->patientRepository, $this->fieldRepository, $this->fieldValueRepository);
    }

    public function testPatientBuilderCanReturnFieldRepository()
    {
        $this->assertSame($this->builder->getFieldRepository(), $this->fieldRepository);
    }

    public function testPatientBuilderCanReturnFieldValueRepository()
    {
        $this->assertSame($this->builder->getFieldValueRepository(), $this->fieldValueRepository);
    }

    public function testPatientBuilderCanCreateNewPatientResource()
    {
        $this->enablePatientCreate();

        $this->builder->create();
        $this->assertAttributeSame($this->patient, 'resource', $this->builder);
    }

    public function testPatientBuilderCreateNewIsFluent()
    {
        $this->patientRepository->shouldReceive('createNew')->once();

        $this->assertSame($this->builder->create(), $this->builder);
    }

    public function testPatientBuilderCanAddFieldWithoutPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, true);

        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testPatientBuilderCanAddFieldWithoutPresentationWithDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(true, true);

        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testPatientBuilderCanAddFieldWithPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, false);

        $this->builder->addField('NAME', 'VALUE', 'PRESENTATION');
    }


    // Privates

    private function enablePatientCreate()
    {
        $this->patientRepository->shouldReceive('createNew')->once()->andReturn($this->patient);
    }

    private function setupFieldAdditionScenario($findInDb, $presentationIsNull)
    {
        $this->enablePatientCreate();
        $this->builder->create();

        $this->patient->shouldReceive('addField')->zeroOrMoreTimes()->andReturn(Mockery::self());
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
