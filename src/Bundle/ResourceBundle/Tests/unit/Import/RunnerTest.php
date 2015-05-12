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
    }

    // tests
    public function testRunnerGetsImporterFromRegistry()
    {
        $subjectName = 'SUBJECT_NAME';

        $importer = Mockery::mock('Accard\Bundle\ResourceBundle\Importer\ImporterInterface')
            ->shouldReceive('getSubject')->andReturn($subjectName)
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

        $this->runner->run('NOT_AN_IMPORTERINTERFACE');

    }

}