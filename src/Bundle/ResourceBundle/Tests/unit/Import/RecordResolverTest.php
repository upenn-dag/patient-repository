<?php
namespace AccardTest\Bundle\ResourceBundle\Import;

/**
 * Record Resolver Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\RecordResolver;
use Accard\Bundle\ResourceBundle\Test\Stub\Stub;
use Mockery;

class RecordResolverTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->factory = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceResolvingFactory');

        $this->resolver = new RecordResolver($this->factory);
    }

    
    public function testRecordResolverGetRecordForImportResolvesAndGetsRecordForImportResource()
    {
        $subjectName = 'SUBJECT';
        $id = 1;

        $repository = Mockery::mock()
            ->shouldReceive('find')->with($id)->once()->andReturn('RESOLVED_TARGET')
            ->getMock()
        ;

        $target = Mockery::mock()
            ->shouldReceive('getRepository')->andReturn($repository)->once()
            ->getMock()
        ;

        $this->factory
            ->shouldReceive('resolveTarget')->with($subjectName)->andReturn($target)->once()
        ;

        $this->assertEquals('RESOLVED_TARGET', $this->resolver->getRecordForImport($subjectName, $id));
    }

    public function testRecordResolverCreateRecordForImportSkipsLogicIfNoRecordFound()
    {
        $subjectName = 'SUBJECT';
        $id = 1;

        $repository = Mockery::mock()
            ->shouldReceive('find')->with($id)->once()->andReturn(null)
            ->getMock()
        ;

        $target = Mockery::mock()
            ->shouldReceive('getRepository')->andReturn($repository)->once()
            ->getMock()
        ;

        $this->factory
            ->shouldReceive('resolveTarget')->with($subjectName)->andReturn($target)->once()
        ;

        $this->assertEmpty($this->resolver->createRecordForImport($subjectName, $id));
    }

    public function testRecordResolverCreateRecordForImportingFromSubjectAndId()
    {
        $subjectName = 'SUBJECT';
        $id = 1;

        $record = Mockery::mock()
        ;

        $stub = new Stub();

        $subjectRepository = Mockery::mock()
            ->shouldReceive('createNew')->once()->andReturn($stub)
            ->getMock()
        ;

        $subject = Mockery::mock()
            ->shouldReceive('getRepository')->once()->andReturn($subjectRepository)
            ->getMock()
        ;

        $repository = Mockery::mock()
            ->shouldReceive('find')->with($id)->once()->andReturn($record)
            ->getMock()
        ;

        $target = Mockery::mock()
            ->shouldReceive('getRepository')->andReturn($repository)->once()
            ->getMock()
        ;

        $this->factory
            ->shouldReceive('resolveTarget')->with($subjectName)->andReturn($target)->once()
            ->shouldReceive('resolveSubject')->with($subjectName)->andReturn($subject)->once()
        ;

        $this->assertSame($stub, $this->resolver->createRecordForImport($subjectName, $id));
    }
}