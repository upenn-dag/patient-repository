<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Model;

use Mockery;
use Accard\Component\Field\Exception\FieldNotFoundException;

/**
 * Field not found exception tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldNotFoundExceptionTest extends \Codeception\TestCase\Test
{
    public function testExceptionMessageContainsFieldNameIfString()
    {
        $exception = new FieldNotFoundException('FIELD');
        $this->assertContains('FIELD', $exception->getMessage());
    }

    public function testExceptionMessageContainsFieldIdIfInteger()
    {
        $exception = new FieldNotFoundException(1);
        $this->assertContains('1', $exception->getMessage());
    }
}
