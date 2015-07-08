<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\FieldValue\Model;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Patient\Model\FieldValue;
use Accard\Component\Patient\Model\FieldValueInterface;

class FieldValueTest extends Test
{
    protected function _before()
    {
        $this->patient = Mockery::mock('Accard\Component\Patient\Model\Patient');
        $this->fieldValue = new FieldValue();
    }

    /**
     * Interface tests
     */
    public function testFieldValueInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Patient\Model\FieldValueInterface',
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

    public function testFieldValueHasPatientAliasForSettingSubject()
    {
        $this->fieldValue->setPatient($this->patient);
        $this->assertAttributeSame($this->patient, 'subject', $this->fieldValue);
    }

    public function testFieldValueHasPatientAliasForGettingSubject()
    {
        $this->fieldValue->setPatient($this->patient);
        $this->assertSame($this->patient, $this->fieldValue->getPatient());
    }
}
