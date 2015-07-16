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
}