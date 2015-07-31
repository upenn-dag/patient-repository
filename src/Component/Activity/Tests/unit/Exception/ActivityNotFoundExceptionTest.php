<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Activity\Exception;

use Codeception\TestCase\Test;
use Accard\Component\Activity\Exception\ActivityNotFoundException;
use DAG\Component\Field\Model\FieldTypes;
use Mockery;

class ActivityNotFoundExceptionTest extends Test
{
    protected function _before()
    {
        $this->exception = new ActivityNotFoundException(1);
    }

    public function testExceptionIsActivityExceptionInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Activity\Exception\ActivityException',
            $this->exception
        );
    }

    public function testExceptionIsRuntimeException()
    {
        $this->assertInstanceOf(
            'InvalidArgumentException',
            $this->exception
        );
    }

    public function testExceptionIndicatesId()
    {
        $exception = new ActivityNotFoundException(1);
        $this->assertAttributeContains('1', 'message', $exception);
    }
}
