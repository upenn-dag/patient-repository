<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Attribute\Model;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Attribute\Model\FieldValue;
use Accard\Component\Attribute\Model\FieldValueInterface;

/**
 * Field value tests.
 * 
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValueTest extends Test
{
    protected function _before()
    {
        $this->sample = Mockery::mock('Accard\Component\Attribute\Model\Attribute');
        $this->fieldValue = new FieldValue();
    }

    /**
     * Interface tests
     */
    public function testFieldValueInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Attribute\Model\FieldValueInterface',
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

    public function testFieldValueHasAttributeAliasForSettingSubject()
    {
        $this->fieldValue->setAttribute($this->sample);
        $this->assertAttributeSame($this->sample, 'subject', $this->fieldValue);
    }

    public function testFieldValueHasAttributeAliasForGettingSubject()
    {
        $this->fieldValue->setAttribute($this->sample);
        $this->assertSame($this->sample, $this->fieldValue->getAttribute());
    }
}
