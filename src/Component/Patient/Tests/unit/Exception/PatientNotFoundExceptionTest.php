<?php

namespace AccardTest\Component\Patient\Exception;

use Codeception\TestCase\Test;
use Accard\Component\Patient\Exception\PatientNotFoundException;
use Accard\Component\Field\Model\FieldTypes;
use Mockery;

class PatientNotFoundExceptionTest extends Test
{
    protected function _before()
    {
        $this->exception = new PatientNotFoundException(1);
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

    public function testExceptionIndicatesIdWhenNumeric()
    {
        $exception = new PatientNotFoundException(1);

        $this->assertAttributeContains('1', 'message', $exception);
    }

    public function testExceptionShowsFieldNameWhenProvidedAsString()
    {
        $exception = new PatientNotFoundException('FIELD', null);

        $this->assertAttributeContains('FIELD', 'message', $exception);
    }

    public function testExceptionCombinesFieldAndValueWhenEachProvided()
    {
        $exception = new PatientNotFoundException('FIELD', 'VALUE');

        $this->assertAttributeContains('FIELD', 'message', $exception);
        $this->assertAttributeContains('VALUE', 'message', $exception);
    }
}
