<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace spec\Accard\Bundle\ResourceBundle\Exception\Driver;

use PhpSpec\ObjectBehavior;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class InvalidDriverExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('driver', 'className');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\ResourceBundle\Exception\Driver\InvalidDriverException');
    }

    function it_should_extends_exception()
    {
        $this->shouldHaveType('\Exception');
    }
}
