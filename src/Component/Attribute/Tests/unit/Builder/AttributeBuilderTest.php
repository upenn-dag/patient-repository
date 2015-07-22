<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Attribute\Builder;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Attribute\Builder\AttributeBuilder;

/**
 * Attribute builder tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AttributeBuilderTest extends Test
{
    protected function _before()
    {
        $this->attribute = Mockery::mock('Accard\Component\Attribute\Model\AttributeInterface');
        $this->field = Mockery::mock('Accard\Component\Attribute\Model\FieldInterface');
        $this->fieldValue = Mockery::mock('Accard\Component\Attribute\Model\FieldValueInterface');

        $this->objectManager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager')
            ->shouldReceive('persist')->zeroOrMoreTimes()
            ->shouldReceive('flush')->zeroOrMoreTimes()
            ->getMock();
        $this->attributeRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');
        $this->fieldRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');
        $this->fieldValueRepository = Mockery::mock('DAG\Component\Resource\Repository\RepositoryInterface');

        $this->builder = new AttributeBuilder($this->objectManager, $this->attributeRepository, $this->fieldRepository, $this->fieldValueRepository);
    }

    public function testAttributeBuilderCanReturnFieldRepository()
    {
        $this->assertSame($this->fieldRepository, $this->builder->getFieldRepository());
    }

    public function testAttributeBuilderCanReturnFieldValueRepository()
    {
        $this->assertSame($this->fieldValueRepository, $this->builder->getFieldValueRepository());
    }

    public function testAttributeBuilderCanCreateNewAttributeResource()
    {
        $this->enableAttributeCreate();
        $this->builder->create();
        $this->assertAttributeSame($this->attribute, 'resource', $this->builder);
    }

    public function testAttributeBuilderCreateIsFluent()
    {
        $this->enableAttributeCreate();
        $this->assertSame($this->builder->create(), $this->builder);
    }

    public function testAttributeBuilderCanAddFieldWithoutPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, true);
        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testAttributeBuilderCanAddFieldWithoutPresentationWithDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(true, true);
        $this->builder->addField('NAME', 'VALUE', null);
    }

    public function testAttributeBuilderCanAddFieldWithPresentationWithoutDatabaseRecord()
    {
        $this->setupFieldAdditionScenario(false, false);
        $this->builder->addField('NAME', 'VALUE', 'PRESENTATION');
    }

    public function testAttributeBuilderAddFieldIsFluent()
    {
        $this->setupFieldAdditionScenario(true, true);
        $this->assertSame($this->builder, $this->builder->addField('NAME', 'VALUE', null));
    }


    // Privates

    private function enableAttributeCreate()
    {
        $this->attributeRepository->shouldReceive('createNew')->once()->andReturn($this->attribute);
    }

    private function setupFieldAdditionScenario($findInDb, $presentationIsNull)
    {
        $this->enableAttributeCreate();
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
