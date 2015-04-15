<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Exception;

use Accard\Component\Option\Exception\OptionNotFoundException;

/**
 * Option not found exception tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionNotFoundExceptionTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->exception = new OptionNotFoundException('OPTION_NAME');
    }

    public function testOptionNotFoundExceptionContainsOptionName()
    {
        // Not strictly necessary, but I want to make sure the message is good.
        $this->assertContains('OPTION_NAME', $this->exception->getMessage());
    }
}
