<?php
namespace Accard\Component\Sample\tests\unit\Model;
/**
 * Source model tests
 *
 * @author Karl Zipser <kzipser@mail.med.upenn.edu>
 */

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Sample\Model\Source;
use Accard\Component\Sample\Model\Sample;
use Mockery;

class SourceTest extends \Codeception\TestCase\Test
{

	protected $source;
    protected $sample;

    protected function _before()
    {
        $this->source = new Source();
        $this->sample = new Sample();
    }
}