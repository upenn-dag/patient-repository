<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Resource\Exception;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Resource\Exception\ImportTargetAlreadySetException;

/**
 * Import target already set exceptiontest.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportTargetAlreadySetExceptionTest extends Test
{
    public function _before()
    {
        $this->importTarget = Mockery::mock('Accard\Component\Resource\Model\ImportTargetInterface');
        $this->importSubject = Mockery::mock('Accard\Component\Resource\Model\ImportSubjectInterface');

        $this->exception = new ImportTargetAlreadySetException($this->importTarget, $this->importSubject);
    }

    public function testExceptionIsResourceException()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Exception\ResourceException',
            $this->exception
        );
    }

    public function testExceptionIsCorrectExceptionType()
    {
        $this->assertInstanceOf(
            'RuntimeException',
            $this->exception
        );
    }

    /**
     * @expectedException Accard\Component\Resource\Exception\ImportTargetAlreadySetException
     */
    public function testExceptionIsThrowable()
    {
        throw $this->exception;
    }

    public function testExceptionContainsClassOfBothArguements()
    {
        $this->assertAttributeContains(get_class($this->importTarget), 'message', $this->exception);
        $this->assertAttributeContains(get_class($this->importSubject), 'message', $this->exception);
    }
}
