<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Activity\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Activity\Model\Collection');
    }

    function it_implements_Accard_collection_interface()
    {
        $this->shouldImplement('Accard\Component\Activity\Model\CollectionInterface');
    }

    function it_implements_Accard_activity_interface()
    {
        $this->shouldImplement('Accard\Component\Activity\Model\ActivityInterface');
    }
}
