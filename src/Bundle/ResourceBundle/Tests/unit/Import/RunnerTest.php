<?php
namespace AccardTest\Bundle\ResourceBundle\Import;

/**
 * Runner Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\Runner;
use Mockery;

class RunnerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->factory = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceResolvingFactory');
        $this->registry = Mockery::mock('Accard\Bundle\ResourceBundle\Import\Registry');

        $this->option = Mockery::mock();
        $this->import = Mockery::mock();
        $this->patient = Mockery::mock();
        $this->diagnosis = Mockery::mock();

        $this->factory
            ->shouldReceive('resolveResource')->with('option', 2)->andReturn($this->option)
            ->shouldReceive('resolveResource')->with('import', 2)->andReturn($this->import)
            ->shouldReceive('resolveResource')->with('patient', 2)->andReturn($this->patient)
            ->shouldReceive('resolveResource')->with('diagnosis', 2)->andReturn($this->diagnosis)
            ->getMock()
        ;

        $this->runner = new Runner($this->factory, $this->registry);

        $this->manager = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ManagerInterface');

        $this->runner->setManager($this->manager);
    }

    // tests
    public function testRunnerGetsImporterFromRegistry()
    {
        $subjectName = 'SUBJECT_NAME';
        $importerName = 'IMPORTER_NAME';

        $importer = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ImporterInterface')
            ->shouldReceive('getSubject')->andReturn($subjectName)
            ->shouldReceive('getName')->andReturn($importerName)
            ->shouldReceive('configureResolver')
            ->shouldReceive('run')
            ->getMock()
        ;

        $subject = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceInterface')
            ->shouldReceive('isSubject')->andReturn(true)
            ->getMock()
        ;

        $target = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ResourceInterface')
            ->shouldReceive('isTarget')->andReturn(true)
            ->getMock()
        ;

        $this->factory
            ->shouldReceive('resolveResource')->with($subjectName, 0)->andReturn($subject)
            ->shouldReceive('resolveResource')->with(sprintf('import_%s', $subjectName), 1)->andReturn($target)
        ;

        $this->registry->shouldReceive('getImporter')->andReturn($importer);

        $repository = Mockery::mock()
            ->shouldReceive('getAllFor')->with($importerName)->andReturn([])
            ->getMock()
        ;

        $this->import->shouldReceive('getRepository')->andReturn($repository);

        $this->manager
            ->shouldReceive('initialize')
            ->shouldReceive('convert')
            ->shouldReceive('persist')
        ;

        $this->runner->run('NOT_AN_IMPORTERINTERFACE');

    }

    public function testRunnerManagerisMutable()
    {
        $manager = Mockery::mock('Accard\Bundle\ResourceBundle\Import\ManagerInterface');

        $this->runner->setManager($manager);

        $this->assertSame($manager, $this->runner->getManager());
    }
}