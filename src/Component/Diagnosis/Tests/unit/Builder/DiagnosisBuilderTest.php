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
use Accard\Component\Diagnosis\Builder\DiagnosisBuilder;

/**
 * Diagnosis builder tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisBuilderTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->objectManager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $this->diagnosisRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');
        $this->fieldRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');
        $this->fieldValueRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');

        $this->builder = new DiagnosisBuilder($this->objectManager, $this->diagnosisRepository, $this->fieldRepository, $this->fieldValueRepository);
    }

    public function testDiagnosisBuilderGetFieldRepositoryReceivesCreateNew()
    {
        $this->diagnosisRepository->shouldReceive('createNew');
        $this->assertSame($this->builder, $this->builder->create());
    }

    public function testDiagnosisBuilderReturnsFieldRepository()
    {
        $this->assertSame($this->fieldRepository, $this->builder->getFieldRepository());
    }

    public function testDiagnosisBuilderReturnsFieldValueRepository()
    {
        $this->assertSame($this->fieldValueRepository, $this->builder->getFieldValueRepository());
    }

    public function testDiagnosisBuilderAddsFieldAndFieldValue()
    {
        $field = Mockery::mock('Accard\Component\Field\Model\FieldInterface');

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

    public function testDiagnosisBuilderAddFieldCreatesNewFieldWhenFieldRepositoryReturnsNull()
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