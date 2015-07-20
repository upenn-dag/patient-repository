<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Behavior\Model;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Behavior\Model\FieldValue;
use Accard\Component\Behavior\Model\FieldValueInterface;

/**
 * Field value tests.
 * 
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValueTest extends Test
{
    protected function _before()
    {
        $this->sample = Mockery::mock('Accard\Component\Behavior\Model\Behavior');
        $this->fieldValue = new FieldValue();
    }

    /**
     * Interface tests
     */
    public function testFieldValueInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Behavior\Model\FieldValueInterface',
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

    public function testFieldValueHasBehaviorAliasForSettingSubject()
    {
        $this->fieldValue->setBehavior($this->sample);
        $this->assertAttributeSame($this->sample, 'subject', $this->fieldValue);
    }

    public function testFieldValueHasBehaviorAliasForGettingSubject()
    {
        $this->fieldValue->setBehavior($this->sample);
        $this->assertSame($this->sample, $this->fieldValue->getBehavior());
    }
}
