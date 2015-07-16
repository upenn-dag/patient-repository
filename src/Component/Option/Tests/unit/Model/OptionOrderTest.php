<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Option\Model;

use Accard\Component\Option\Model\OptionOrder;

/**
 * Option order types class tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionOrderTest extends \Codeception\TestCase\Test
{
    public function testOptionTypeYieldsChoices()
    {
        $this->assertInternalType('array', OptionOrder::getChoices());
    }

    public function testOptionTypeYieldsChoiceKeys()
    {
        $this->assertInternalType('array', OptionOrder::getKeys());
    }
}
