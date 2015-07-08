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

use DateTime;
use Codeception\Specify;
use Accard\Component\Activity\Model\Activity;
use Accard\Component\Activity\Model\ActivityInterface;

/**
 * Activity model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityTest extends \Codeception\TestCase\Test
{
    use Specify;

    public function _before()
    {
        $this->activity = new Activity();
    }

    public function testActivityCreation()
    {
        $this->specify('interface is followed', function() {
            $this->assertInstanceOf(
                'Accard\Component\Activity\Model\ActivityInterface',
                $this->activity
            );
        });

        $this->specify('id is unset on creation', function() {
            $this->assertNull($this->activity->getId());
        });

        $this->specify('fields collection is initialized and empty on creation', function() {
            $this->assertAttributeInstanceOf(
                'Doctrine\Common\Collections\Collection',
                'fields',
                $this->activity
            );
            $this->assertAttributeCount(0, 'fields', $this->activity);
            $this->assertCount(0, $this->activity->getFields());
        });

        $this->specify('date is mutable', function() {
            $date = new DateTime();
            $this->activity->setActivityDate($date);

            $this->assertAttributeSame($date, 'activityDate', $this->activity);
            $this->assertSame($date, $this->activity->getActivityDate());
        });
    }
}
