<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Activity\Model;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Activity\Model\FieldValue;
use Accard\Component\Activity\Model\FieldValueInterface;

class FieldValueTest extends Test
{
    protected function _before()
    {
        $this->activity = Mockery::mock('Accard\Component\Activity\Model\Activity');
        $this->fieldValue = new FieldValue();
    }

    /**
     * Interface tests
     */
    public function testFieldValueInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Activity\Model\FieldValueInterface',
            $this->fieldValue
        );
    }

    public function testFieldValueIdIsUnsetOnCreation()
    {
        $this->assertNull($this->fieldValue->getId());
    }

    public function testFieldValueSubjectIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'subject', $this->fieldValue);
    }

    public function testFieldValueHasActivityAliasForSettingSubject()
    {
        $this->fieldValue->setActivity($this->activity);
        $this->assertAttributeSame($this->activity, 'subject', $this->fieldValue);
    }

    public function testFieldValueHasActivityAliasForGettingSubject()
    {
        $this->fieldValue->setActivity($this->activity);
        $this->assertSame($this->activity, $this->fieldValue->getActivity());
    }
}
