<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Diagnosis\Exception;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Diagnosis\Exception\DiagnosisNotFoundException;
use Accard\Component\Field\Model\FieldTypes;

/**
 * Diagnosis not found exception tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisNotFoundExceptionTest extends Test
{
    protected function _before()
    {
        $this->exception = new DiagnosisNotFoundException('FIELD');
    }

    public function testExceptionIsDiagnosisExceptionInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Diagnosis\Exception\DiagnosisException',
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

    public function testExceptionContainsIdWhenGivenNumericInput()
    {
    	$expected = 1;
    	$exception = new DiagnosisNotFoundException($expected);
    	$this->assertAttributeContains((string) $expected, 'message', $exception);
    }

    public function testExceptionContainsFieldWhenStringInputWithoutValue()
    {
    	$expected = 'FIELD';
    	$exception = new DiagnosisNotFoundException($expected);
    	$this->assertAttributeContains($expected, 'message', $exception);
    }

    public function testExceptionContainsFieldAndValueWhenGivenBothArgumentsAsStrings()
    {
    	$expected1 = 'FIELD';
    	$expected2 = 'VALUE';
    	$exception = new DiagnosisNotFoundException($expected1, $expected2);
    	$this->assertAttributeContains($expected1, 'message', $exception);
    	$this->assertAttributeContains($expected2, 'message', $exception);
    }
}
