<?php

namespace AccardTest\Component\Patient\Exception;

use Codeception\TestCase\Test;
use Accard\Component\Patient\Exception\MultiplePatientsFoundException;
use DAG\Component\Field\Model\FieldTypes;
use Mockery;

class MultiplePatientsFoundExceptionTest extends Test
{
    protected function _before()
    {
        $this->exception = new MultiplePatientsFoundException();
    }

    public function testExceptionIsPatientExceptionInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Patient\Exception\PatientException',
            $this->exception
        );
    }

    public function testExceptionIsRuntimeException()
    {
        $this->assertInstanceOf(
            'RuntimeException',
            $this->exception
        );
    }
}
