<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Core\Model;

require_once __DIR__.'/ModelBehavior.php';

use Accard\Component\Core\Model\Collection;
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SampleSpec extends ModelBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Core\Model\Sample');
    }

    function it_implements_Accard_collection_interface()
    {
        $this->shouldImplement('Accard\Component\Core\Model\SampleInterface');
    }

    // Collection

    function it_has_no_collection_by_default()
    {
        $this->getCollection()->shouldReturn(null);
    }

    function its_collection_is_mutable(Collection $collection)
    {
        $this->setCollection($collection);
        $this->getCollection()->shouldReturn($collection);
    }

    function its_collection_is_nullable()
    {
        $this->setCollection(null);
        $this->getCollection()->shouldReturn(null);
    }
}
