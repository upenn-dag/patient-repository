<?php
namespace AccardTest\Component\Phase\Exception;

/**
 * Phase not found exception test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Component\Phase\Exception\PhaseNotFoundException;
use Mockery;

class PhaseNotFoundExceptionTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->mock = Mockery::mock('Accard\Component\Phase\Exception\PhaseNotFoundException');
    }

    protected function _after()
    {
    }

    /**
     * Interface Tests
     */
    public function testPhaseNotFoundExceptionInstanceOfRunTimeException()
    {
        $this->assertInstanceOf('RuntimeException', $this->mock);
    }

    /**
     * PhaseNotFoundException->message
     */
    public function testPhaseNotFoundExceptionMessageFormatsCorrectly()
    {
        $this->exception = new PhaseNotFoundException('NAME');

        $this->assertAttributeEquals('Phase with label "NAME" not found.', 'message', $this->exception);
    }
}