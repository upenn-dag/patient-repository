<?php
namespace AccardTest\Component\Sample\Builder;

use Accard\Component\Sample\Builder\SampleBuilder;
use Mockery;

class SampleBuilderTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;


    protected function _before()
    {
        $this->objectManager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $this->patientRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');
        $this->fieldRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');
        $this->fieldValueRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');

        $this->builder = new SampleBuilder($this->objectManager, $this->patientRepository, $this->fieldRepository, $this->fieldValueRepository);

    }

    protected function _after()
    {
    }

    public function testPatientBuilderGetFieldRepositoryReceivesCreateNew()
    {
        $this->sampleRepository->shouldReceive('createNew');

        $this->assertSame($this->builder, $this->builder->create());
    }

    public function testSampleBuilderReturnsFieldRepository()
    {
        $this->assertSame($this->fieldRepository, $this->builder->getFieldRepository());
    }

    public function testSampleBuilderReturnsFieldValueRepository()
    {
        $this->assertSame($this->fieldValueRepository, $this->builder->getFieldValueRepository());
    }

    public function testSampleBuilderAddsFieldAndFieldValue()
    {
       
        $field = Mockery::mock('Accard\Component\Field\Model\FieldInterface');
        $field->shouldReceive('addField');
        $this->builder->set($field);
       
        $this->fieldRepository->shouldReceive('findOneBy')->andReturn(null);

        $fieldValue = Mockery::mock('Accard\Component\Field\Model\FieldValueInterface');
        $fieldValue->shouldReceive('setField');
        $fieldValue->shouldReceive('setValue');

        $resource = Mockery::mock();
        $resource->shouldReceive('addField');
        $this->builder->set($resource);

        $this->fieldRepository->shouldReceive('findOneBy')->andReturn($field);
        $this->fieldValueRepository->shouldReceive('createNew')->andReturn($fieldValue);

        $this->assertSame($this->builder, $this->builder->addField('NAME', 'VALUE'));
    }

    public function testSampleBuilderAddFieldCreatesNewFieldWhenFieldRepositoryReturnsNull()
    {
        $resource = Mockery::mock();
        $resource->shouldReceive('addField');
        $this->builder->set($resource);

        $this->fieldRepository->shouldReceive('findOneBy')->andReturn(null);

        $field = Mockery::mock('Accard\Component\Field\Model\FieldInterface');

        $this->fieldRepository->shouldReceive('createNew')->andReturn($field);
        $field->shouldReceive('setName')->with('NAME');
        $field->shouldReceive('setPresentation')->with('PRESENTATION');

        $this->objectManager->shouldReceive('persist')->with($field);
        $this->objectManager->shouldReceive('flush')->with($field);

        $fieldValue = Mockery::mock('Accard\Component\Field\Model\FieldValueInterface');
        $fieldValue->shouldReceive('setField');
        $fieldValue->shouldReceive('setValue');
        $this->fieldValueRepository->shouldReceive('createNew')->andReturn($fieldValue);

        $this->assertSame($this->builder, $this->builder->addField('NAME', 'VALUE', 'PRESENTATION'));
    }
}