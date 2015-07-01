<?php
namespace AccardTest\Component\Activity\Builder;

/**
 * Attribut eBuilder Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Component\Activity\Builder\ActivityBuilder;
use Mockery;

class ActivityBuilderTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->objectManager = Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $this->activityRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');
        $this->fieldRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');
        $this->fieldValueRepository = Mockery::mock('Accard\Component\Resource\Repository\RepositoryInterface');

        $this->builder = new ActivityBuilder($this->objectManager, $this->activityRepository, $this->fieldRepository, $this->fieldValueRepository);

    }

    protected function _after()
    {
    }

    public function testActivityBuilderGetFieldRepositoryReceivesCreateNew()
    {
        $this->activityRepository->shouldReceive('createNew');

        $this->assertSame($this->builder, $this->builder->create());
    }

    public function testActivityBuilderReturnsFieldRepository()
    {
        $this->assertSame($this->fieldRepository, $this->builder->getFieldRepository());
    }

    public function testActivityBuilderReturnsFieldValueRepository()
    {
        $this->assertSame($this->fieldValueRepository, $this->builder->getFieldValueRepository());
    }

    public function testActivityBuilderAddsFieldAndFieldValue()
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

    public function testActivityBuilderAddFieldCreatesNewFieldWhenFieldRepositoryReturnsNull()
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