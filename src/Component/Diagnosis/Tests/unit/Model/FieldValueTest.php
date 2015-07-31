<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Diagnosis\Model;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Diagnosis\Model\FieldValue;
use Accard\Component\Diagnosis\Model\FieldValueInterface;

/**
 * Field value tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValueTest extends Test
{
    protected function _before()
    {
        $this->diagnosis = Mockery::mock('Accard\Component\Diagnosis\Model\Diagnosis');
        $this->fieldValue = new FieldValue();
    }

    /**
     * Interface tests
     */
    public function testFieldValueInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Diagnosis\Model\FieldValueInterface',
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

    public function testFieldValueHasDiagnosisAliasForSettingSubject()
    {
        $this->fieldValue->setDiagnosis($this->diagnosis);
        $this->assertAttributeSame($this->diagnosis, 'subject', $this->fieldValue);
    }

    public function testFieldValueHasDiagnosisAliasForGettingSubject()
    {
        $this->fieldValue->setDiagnosis($this->diagnosis);
        $this->assertSame($this->diagnosis, $this->fieldValue->getDiagnosis());
    }
}
