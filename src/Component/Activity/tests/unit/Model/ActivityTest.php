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

use Accard\Component\Activity\Model\Activity;
use Accard\Component\Activity\Model\ActivityInterface;

/**
 * Activity model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    public function testCreation()
    {
        $activity = new Activity();

        $this->specify('interface is followed', function() {
            $this->assertTrue($activity instanceof ActivityInterface);
        });
    }
}