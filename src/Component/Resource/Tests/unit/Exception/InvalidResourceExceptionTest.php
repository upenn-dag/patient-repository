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

use stdClass;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Resource\Exception\InvalidResourceException;

/**
 * Invalid resource exception tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class InvalidResourceExceptionTest extends Test
{
    public function _before()
    {
        $this->exception = new InvalidResourceException('EXPECTED', 'string');
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
            'InvalidArgumentException',
            $this->exception
        );
    }

    /**
     * @expectedException Accard\Component\Resource\Exception\InvalidResourceException
     */
    public function testExceptionIstThrowable()
    {
        throw $this->exception;
    }

    public function testExceptionContainsExpectedAndActualType()
    {
        $this->assertAttributeContains('EXPECTED', 'message', $this->exception);
        $this->assertAttributeContains('string', 'message', $this->exception);
    }

    public function testExceptionContainsExpectedAndActualClass()
    {
        $object = new stdClass();
        $exception = new InvalidResourceException('string', $object);
        $this->assertAttributeContains('string', 'message', $exception);
        $this->assertAttributeContains(get_class($object), 'message', $exception);
    }
}
