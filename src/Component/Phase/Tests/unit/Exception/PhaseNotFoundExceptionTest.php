<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Phase\Exception;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Phase\Exception\PhaseNotFoundException;

/**
 * Phase not found exception tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PhaseNotFoundExceptionTest extends Test
{
    protected function _before()
    {
        $this->exception = new PhaseNotFoundException('LABEL');
    }

    public function testPhaseNotFoundExceptionInstanceOfRunTimeException()
    {
        $this->assertInstanceOf('RuntimeException', $this->exception);
    }

    public function testPhaseNotFoundExceptionMessageFormatsCorrectly()
    {
        $this->assertAttributeContains('LABEL', 'message', $this->exception);
    }
}
